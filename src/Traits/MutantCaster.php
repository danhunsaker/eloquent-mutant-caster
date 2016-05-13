<?php

namespace Danhunsaker\Eloquent\Traits;

use Illuminate\Support\Str;

trait MutantCaster
{
    public function hasGetMutator($key)
    {
        if ($this->hasCast($key) && method_exists($this, 'get' . Str::studly($this->getCastType($key)) . 'Attribute')) {
            return true;
        } else {
            return parent::hasGetMutator($key);
        }
    }

    protected function mutateAttribute($key, $value)
    {
        $type = Str::studly(parent::hasGetMutator($key) ? $key : $this->getCastType($key));

        return $this->{'get' . $type . 'Attribute'}($value);
    }

    public function setAttribute($key, $value)
    {
        if ($this->hasCast($key) && method_exists($this, 'set' . Str::studly($this->getCastType($key)) . 'Attribute')) {
            return $this->{'set' . Str::studly($this->getCastType($key)) . 'Attribute'}($key, $value);
        } else {
            return parent::setAttribute($key, $value);
        }
    }
}
