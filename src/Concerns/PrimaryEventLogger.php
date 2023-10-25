<?php

namespace Noxo\FilamentActivityLog\Concerns;

trait PrimaryEventLogger
{
    /**
     * Log when a model is created.
     */
    public function created(): void
    {
        $attributes = [];

        foreach ($this->fields as $key) {
            if (! empty($value = $this->getValue($key))) {
                $attributes[$key] = $value;
            }
        }

        $this->log(['old' => [], 'attributes' => $attributes]);
    }

    /**
     * Log when a model is updated.
     */
    public function updated(): void
    {
        $old = [];
        $new = [];

        foreach ($this->fields as $key) {
            $beforeValue = $this->getValue($key);
            $afterValue = $this->getValue($key, fromAfter: true);

            if ($beforeValue !== $afterValue) {
                $old[$key] = $beforeValue;
                $new[$key] = $afterValue;
            }
        }

        $this->logIf($old !== $new, ['old' => $old, 'attributes' => $new]);
    }

    /**
     * Log when a model is deleted.
     */
    public function deleted(): void
    {
        $attributes = [];

        foreach ($this->fields as $key) {
            if (! empty($value = $this->getValue($key))) {
                $attributes[$key] = $value;
            }
        }

        $this->log(['old' => [], 'attributes' => $attributes]);
    }

    /**
     * Log when a model is restored.
     */
    public function restored(): void
    {
        $this->log(['old' => [], 'attributes' => []]);
    }
}
