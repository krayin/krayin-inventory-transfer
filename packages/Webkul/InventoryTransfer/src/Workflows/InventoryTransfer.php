<?php

namespace Webkul\InventoryTransfer\Workflows;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Automation\Helpers\Entity\AbstractEntity;
use Webkul\Core\Traits\PDFHandler;
use Webkul\EmailTemplate\Repositories\EmailTemplateRepository;
use Webkul\InventoryTransfer\Enums\InventoryTransferStatus;
use Webkul\InventoryTransfer\Notifications\Common;
use Webkul\InventoryTransfer\Repositories\InventoryTransferRepository;

class InventoryTransfer extends AbstractEntity
{
    use PDFHandler;

    /**
     * Define the entity type.
     *
     * @var string
     */
    protected $entityType = 'inventory_transfers';

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected EmailTemplateRepository $emailTemplateRepository,
        protected InventoryTransferRepository $inventoryTransferRepository
    ) {}

    /**
     * Listing of the entities.
     *
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransfer|int  $entity
     * @return \Webkul\InventoryTransfer\Contracts\InventoryTransfer
     */
    public function getEntity($entity)
    {
        if (! $entity instanceof \Webkul\InventoryTransfer\Contracts\InventoryTransfer) {
            $entity = $this->inventoryTransferRepository->find($entity);
        }

        return $entity;
    }

    /**
     * Returns attributes
     *
     * @param  string  $entityType
     */
    public function getAttributes($entityType, $skipAttributes = ['textarea', 'image', 'file', 'address']): array
    {
        $attributes = parent::getAttributes($entityType, $skipAttributes);

        $attributes = array_values(array_filter($attributes, function ($item) {
            return $item['id'] !== 'status';
        }));

        $attributes = array_merge($attributes, [
            [
                'id'          => 'status',
                'type'        => 'select',
                'name'        => trans('inventory_transfer::app.settings.workflows.inventory-transfers.status'),
                'lookup_type' => null,
                'options'     => collect(InventoryTransferStatus::cases())->map(function ($status) {
                    return [
                        'id'   => $status->value,
                        'name' => $status->label(),
                    ];
                }),
            ],
        ]);

        return $attributes;
    }

    /**
     * Returns placeholders for email templates.
     *
     * @param  array  $entity
     */
    public function getEmailTemplatePlaceholders($entity): array
    {
        $emailTemplates = parent::getEmailTemplatePlaceholders($entity);

        $emailTemplates['menu'][] = [
            'text'  => trans('inventory_transfer::app.settings.workflows.inventory-transfers.attach-pdf'),
            'value' => '{%inventory_transfers.attach_pdf%}',
        ];

        return $emailTemplates;
    }

    /**
     * Returns workflow actions.
     *
     * @return array
     */
    public function getActions()
    {
        $emailTemplates = $this->emailTemplateRepository->all(['id', 'name']);

        return [
            [
                'id'         => 'update_inventory_transfer',
                'name'       => trans('inventory_transfer::app.settings.workflows.inventory-transfers.update-inventory-transfer'),
                'attributes' => $this->getAttributes('inventory_transfers'),
            ], [
                'id'      => 'send_email_to_assignee',
                'name'    => trans('inventory_transfer::app.settings.workflows.inventory-transfers.send-email-to-assignee'),
                'options' => $emailTemplates,
            ], [
                'id'      => 'send_email_to_creator',
                'name'    => trans('inventory_transfer::app.settings.workflows.inventory-transfers.send-email-to-creator'),
                'options' => $emailTemplates,
            ], [
                'id'      => 'send_email_to_source_warehouse',
                'name'    => trans('inventory_transfer::app.settings.workflows.inventory-transfers.send-email-to-source-warehouse'),
                'options' => $emailTemplates,
            ], [
                'id'      => 'send_email_to_destination_warehouse',
                'name'    => trans('inventory_transfer::app.settings.workflows.inventory-transfers.send-email-to-destination-warehouse'),
                'options' => $emailTemplates,
            ],
        ];
    }

    /**
     * Execute workflow actions.
     *
     * @param  \Webkul\Automation\Contracts\Workflow  $workflow
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransfer  $InventoryTransfer
     * @return array
     */
    public function executeActions(mixed $workflow, mixed $inventoryTransfer): void
    {
        foreach ($workflow->actions as $action) {
            switch ($action['id']) {
                case 'update_inventory_transfer':
                    $this->inventoryTransferRepository->update([
                        'entity_type'        => 'inventory_transfers',
                        $action['attribute'] => $action['value'],
                    ], $inventoryTransfer->id);

                    break;

                case 'send_email_to_assignee':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        $attachments = $this->getEmailAttachments($inventoryTransfer, $emailTemplate);

                        Mail::queue(new Common([
                            'to'          => $inventoryTransfer->assigned_to->email,
                            'subject'     => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->subject),
                            'body'        => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->content),
                            'attachments' => $attachments,
                        ]));
                    } catch (\Exception $e) {
                    }

                    break;

                case 'send_email_to_creator':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        $attachments = $this->getEmailAttachments($inventoryTransfer, $emailTemplate);

                        Mail::queue(new Common([
                            'to'          => $inventoryTransfer->creator->email,
                            'subject'     => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->subject),
                            'body'        => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->content),
                            'attachments' => $attachments,
                        ]));
                    } catch (\Exception $e) {
                    }

                    break;

                case 'send_email_to_source_warehouse':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        $attachments = $this->getEmailAttachments($inventoryTransfer, $emailTemplate);

                        Mail::queue(new Common([
                            'to'          => data_get($inventoryTransfer->from_warehouse->emails, '*.value'),
                            'subject'     => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->subject),
                            'body'        => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->content),
                            'attachments' => $attachments,
                        ]));
                    } catch (\Exception $e) {
                    }

                    break;

                case 'send_email_to_destination_warehouse':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        $attachments = $this->getEmailAttachments($inventoryTransfer, $emailTemplate);

                        Mail::queue(new Common([
                            'to'          => data_get($inventoryTransfer->to_warehouse->emails, '*.value'),
                            'subject'     => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->subject),
                            'body'        => $this->replacePlaceholders($inventoryTransfer, $emailTemplate->content),
                            'attachments' => $attachments,
                        ]));
                    } catch (\Exception $e) {
                    }

                    break;
            }
        }
    }

    /**
     * Replace placeholders with values
     */
    public function replacePlaceholders(mixed $entity, string $content): string
    {
        $content = parent::replacePlaceholders($entity, $content);

        $content = str_replace('{%inventory_transfers.attach_pdf%}', '', $content);

        return $content;
    }

    /**
     * Check if email template has attachment.
     */
    public function getEmailAttachments($inventoryTransfer, $emailTemplate)
    {
        $attachAttachments = strpos($emailTemplate->content, '{%inventory_transfers.attach_pdf%}') !== false;

        if (! $attachAttachments) {
            return [];
        }

        $pdf = $this->downloadPDF(
            view('inventory_transfer::inventory-transfers.pdf', compact('inventoryTransfer'))->render()
        );

        $tempFileName = 'temp_'.uniqid().'.pdf';

        Storage::disk('local')->put('temp/'.$tempFileName, $pdf->getContent());

        $attachments[] = [
            'path' => 'temp/'.$tempFileName,
            'name' => 'inventory-transfer-'.$inventoryTransfer->created_at->format('d-m-Y').'.pdf',
            'mime' => 'application/pdf',
        ];

        return $attachments;
    }
}
