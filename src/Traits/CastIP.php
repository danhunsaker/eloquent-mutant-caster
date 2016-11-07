<?php

namespace Danhunsaker\Eloquent\Traits;

trait CastIP
{
    protected function getIpAttribute($value)
    {
        if ( ! is_null($value)) {
            $value = inet_ntop(gmp_export(gmp_init($value)));
        }

        return $value;
    }

    protected function setIpAttribute($key, $value)
    {
        if ( ! is_null($value)) {
            $value = gmp_strval(gmp_import(inet_pton($value)));
        }

        $this->attributes[$key] = $value;

        return $this;
    }
}
