<?php
/*
 *    Copyright 2012-2016 Youzan, Inc.
 *
 *    Licensed under the Apache License, Version 2.0 (the "License");
 *    you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *    Unless required by applicable law or agreed to in writing, software
 *    distributed under the License is distributed on an "AS IS" BASIS,
 *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *    See the License for the specific language governing permissions and
 *    limitations under the License.
 */

namespace Zan\Framework\Utilities\Types;


use Zan\Framework\Foundation\Exception\System\InvalidArgumentException;

class Func
{
    public static function toClosure(callable $func, $args=null, callable $validator=null)
    {
        if(!is_callable($func)){
            throw new InvalidArgumentException('Func::toClousure first args must be callable');
        }

        return function() use ($func, $args, $validator) {
            if(null !== $validator) {
                $validArgs = func_get_args();
                if(!Func::call($validator, $validArgs)){
                    return null;
                }
            }
            
            return Func::call($func, $args);
        };
    }
    
    public static function call(callable $func, $args=null)
    {
        if(!is_callable($func)){
            throw new InvalidArgumentException('Func::call first args must be callable');
        }
        
        if(null===$args){
            return call_user_func($func);
        }

        if(!is_array($args)){
            $args = [$args];
        }

        return call_user_func_array($func, $args);
    }

}