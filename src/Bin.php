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
namespace Hephaestus;

use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;
use GetOptionKit\ContinuousOptionParser;
use GetOptionKit\OptionPrinter\ConsoleOptionPrinter;
use Hephaestus\Generate\Generate;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @version 0.0.0
 */
class Bin
{
    /**
     * Parsed arguments passed to script
     * @var \GetOptionKit\OptionResult
     */
    protected $arguments;

    /**
     * @var object
     */
    protected $subCommandOptions;

    /**
     * Get argument specifications
     * @return OptionCollection
     */
    public static function getArgumentSpecifications()
    {


        $specs = new OptionCollection();

        $specs->add('d|debug', 'Show debug messages');//->defaultValue(false);
        $specs->add('h|help',  'Show help');//->defaultValue(false);
        $specs->add('version',  'Show version');//->defaultValue(false);
        return $specs;
    }

    public static function getSubCommandsSpecs()
    {
        $generateSpecs = new OptionCollection();
        $generateSpecs->add('i|input:',  'Input file')
            ->isa('File');
        $generateSpecs->add('o|output?', 'Output directory')
            ->isa('String')
            ->defaultValue(null);

        $subCommandSpecs = (object) [
            'generate' => $generateSpecs
        ];

        return $subCommandSpecs;
    }

    /**
     * @param array $argv Array of arguments passed to script
     * @example
     * ```php
     * $binary = new Bin([
     *     __FILE__,
     *     '--help'
     * ]);
     *
     * return $binary->invoke();
     * ```
     */
    public function __construct($argv)
    {
        $parser = new ContinuousOptionParser(static::getArgumentSpecifications());
        $subCommandSpecs = static::getSubCommandsSpecs();

        $subCommands = array_keys((array) $subCommandSpecs);

        //Parse specification arguments from given arguments
        $this->arguments = $parser->parse($argv);

        $arguments = [];
        $subCommandOptions = new \stdClass();

        while (!$parser->isEnd()) {
            if (@$subCommands[0] && $parser->getCurrentArgument() == $subCommands[0]) {
                $parser->advance();
                $subCommand = array_shift($subCommands);
                $parser->setSpecs($subCommandSpecs->{$subCommand});
                $subCommandOptions->{$subCommand} = $parser->continueParse();
            } else {
                $arguments[] = $parser->advance();
            }
        }

        $this->subCommandOptions = $subCommandOptions;
    }

    /**
     * Invoke scripts
     * @return integer Returns indicate how the script exited.
     * Normal exit is generally represented by a 0 return.
     */
    public function invoke()
    {
        echo 'Hephaestus v' . Hephaestus::VERSION . PHP_EOL;

        $arguments         = $this->arguments;
        $subCommandOptions = $this->subCommandOptions;

        if ($arguments->help) {
            echo 'Help:' . PHP_EOL;
            $printer = new ConsoleOptionPrinter;
            echo $printer->render(static::getArgumentSpecifications());
            return 0;
        }

        if (isset($subCommandOptions->generate)) {
            echo 'generate' . PHP_EOL;

            return (new Generate($subCommandOptions->generate));

            //var_dump($subCommandOptions->generate);

            //foreach ($subCommandOptions->generate as $key => $spec) {
            //    echo $spec . PHP_EOL;
            //}
        }
    }
}
