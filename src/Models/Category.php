<?php

namespace MorgenlandSearch\Models;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

class Category extends Model
{

    protected $attributes = ['id'];
    public function getTableName(): string
    {
        return 'Category';
    }


    /**
     * Convert the model's attributes to an array.
     */
    public function attributesToArray(): array
    {
        return [];
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute(
        $key
    )
    {

    }

    /**
     * Get a plain attribute
     */
    public function getAttributeValue(
         $key
    )
    {
        return $this;
    }


    /**
     * Determine if a get mutator exists for an attribute.
     */
    public function hasGetMutator(
         $key
    ): bool
    {
        return false;
    }


    /**
     * Set a given attribute on the model.
     */
    public function setAttribute(
         $key,
               $value
    ): self
    {
        return $this;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     */
    public function hasSetMutator(
         $key
    ): bool
    {
        return false;
    }

    /**
     * Set a given JSON attribute on the model.
     */
    public function fillJsonAttribute(
         $key,
               $value
    ): self
    {
        return $this;
    }

    /**
     * Decode the given JSON back into an array or object.
     */
    public function fromJson(
         $value,
           $asObject = false
    )
    {
    }

    /**
     * Convert a DateTime to a storable string.
     */
    public function fromDateTime(
        $value
    ): string
    {
        return '';
    }

    /**
     * Get the attributes that should be converted to dates.
     */
    public function getDates(): array
    {
        return [];
    }

    /**
     * Set the date format used by the model.
     */
    public function setDateFormat(
         $format
    ): self
    {
        return $this;
    }

    /**
     * Determine whether an attribute should be cast to a native type.
     */
    public function hasCast(
         $key,
               $types = null
    ): bool
    {
        return false;
    }

    /**
     * Get the casts array.
     */
    public function getCasts(): array
    {
        return [];
    }


    public function getAttributes(): array
    {
        return [];
    }

    /**
     * Set the array of model attributes. No checking is done.
     */
    public function setRawAttributes(
         $attributes,
          $sync = false
    ): self
    {
        return $this;
    }

    /**
     * Get the model's original attribute values.
     */
    public function getOriginal(
         $key = null,
               $default = null
    )
    {

    }

    /**
     * Get a subset of the model's attributes.
     */
    public function only(
        $attributes
    ): array
    {
        return [];
    }

    /**
     * Sync the original attributes with the current.
     */
    public function syncOriginal(): self
    {
        return $this;
    }

    /**
     * Sync a single original attribute with its current value.
     */
    public function syncOriginalAttribute(
         $attribute
    ): self
    {
        return $this;
    }

    /**
     * Sync the changed attributes.
     */
    public function syncChanges(): self
    {
        return $this;
    }

    /**
     * Determine if the model or given attribute(s) have been modified.
     */
    public function isDirty(
        $attributes = null
    ): bool
    {
        return false;
    }

    /**
     * Determine if the model or given attribute(s) have remained the same.
     */
    public function isClean(
        $attributes = null
    ): bool
    {
        return false;
    }

    /**
     * Determine if the model or given attribute(s) have been modified.
     */
    public function wasChanged(
        $attributes = null
    ): bool
    {
        return false;
    }

    /**
     * Get the attributes that have been changed since last sync.
     */
    public function getDirty(): array
    {
        return [];
    }

    /**
     * Get the attributes that were changed.
     */
    public function getChanges(): array
    {
        return [];
    }

    /**
     * Get the mutated attributes for a given instance.
     */
    public function getMutatedAttributes(): array
    {
        return [];
    }

    /**
     * Extract and cache all the mutated attributes of a class.
     */
    public static function cacheMutatedAttributes($class)
    {
    }

    public function relationLoaded()
    {
    }

}