<?php

namespace App\Modules\Electrons\Documents;

use App\Modules\Models\Document;
use App\Modules\Nucleons\Service;

class DocumentService extends Service
{
    /**
     * The ID card type.
     */
    const TYPE_ID_CARD = 0;

    /**
     * The payment proof type.
     */
    const TYPE_PAYMENT_PROOF = 1;

    /**
     * The URL to the default file.
     *
     * @var string
     */
    protected $defaultFile = 'images/default.jpg';

    /**
     * The main model for the service.
     *
     * @var Document
     */
    protected $model = Document::class;

    /**
     * Get multiple documents with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'user')) {
            $query->ofUser($params['user']);
        }

        if (array_has($params, 'entry')) {
            $query->ofEntry($params['entry']);
        }

        if (array_has($params, 'type')) {
            $query->ofType($params['type']);
        }

        return $query->get();
    }

    /**
     * Create a new document and return it.
     *
     * @param  array  $data
     * @return Document
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['user_id'] = $data['user'];
        
        if (! array_has($cleaned, 'file')) {
            $cleaned['file'] = $this->defaultFile;
        }

        $document = Document::create($cleaned);

        return $document;
    }

    /**
     * Update a document with new data.
     *
     * @param  Document  $document
     * @param  array     $data
     * @return this
     */
    public function update(Document $document, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $document->{$field} = $value;
        }

        $document->save();

        return $this;
    }

    /**
     * Remove a document from the database.
     *
     * @param  Document  $document
     * @return this
     */
    public function remove(Document $document)
    {
        $document->delete();

        return $this;
    }
}
