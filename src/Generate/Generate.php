<?php
/**
 * Copyright 2015-2016 Xenofon Spafaridis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Hephaestus\Generate;

use Exception;
use Phramework\Exceptions\IncorrectParametersException;
use Phramework\Exceptions\MissingParametersException;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\URLValidator;
use Phramework\Validate\StringValidator;

class Generate
{
    public static function getResourceValidator()
    {
        return new ObjectValidator(
            (object) [
                'data' => new  ObjectValidator(
                    (object) [
                        /*'links' => new ObjectValidator(
                            (object) [
                                'self' => new URLValidator(),
                                'related' => new URLValidator()
                            ],
                            ['self']
                        ),*/
                        'id'   => new StringValidator(1),
                        'type' => new StringValidator(1)
                    ],
                    ['id', 'type']
                )
            ],
            ['data']
        );
    }

    public function __construct($options)
    {
        echo 'Input:' . $options->input . PHP_EOL;

        if (!$options->input) {
            throw new Exception('input argument is required for export subcommand');
        }

        $contents = file_get_contents($options->input);

        //validate json

        $object = json_decode($contents);

        //validate object using ObjectValidator

        $validator = static::getResourceValidator();

        try {
            $resource = $validator->parse($object);
        } catch (MissingParametersException $e) {
            var_dump($e->getParameters());
        } catch (IncorrectParametersException $e) {
            var_dump($e->getParameters());
        }

        var_export($resource);

        return 0;
    }
}