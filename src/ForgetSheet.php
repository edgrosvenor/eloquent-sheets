<?php

namespace Grosv\EloquentSheets;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ForgetSheet
{
    public function execute($id)
    {
        File::delete(config('sushi.cache-path').'/'.$id.'.sqlite');

        $this->triggerCallback($id);

        return response()->noContent();
    }

    protected function triggerCallback($id)
    {
        $class = 'App\\'.Str::studly(str_replace('sushi-', '', $id));
        $model = new $class();

        if (method_exists($model, 'onForget')) {
            $model->onForget();
        }
    }
}
