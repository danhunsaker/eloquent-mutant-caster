<?php

namespace Danhunsaker\Eloquent\Traits;

trait CastIP
{
    protected function getIpAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        return inet_ntop(gmp_export(gmp_init($value)));
    }

    protected function setIpAttribute($key, $value)
    {
        if (is_null($value)) {
            $this->attributes[$key] = null;
        } else {
            $this->attributes[$key] = gmp_strval(gmp_import(inet_pton($value)));
        }

        return $this;
    }
}
