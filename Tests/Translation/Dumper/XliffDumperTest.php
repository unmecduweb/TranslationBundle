<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace MWEB\TranslationBundle\Tests\Translation\Dumper;

use MWEB\TranslationBundle\Model\Message;

use MWEB\TranslationBundle\Model\MessageCatalogue;

use MWEB\TranslationBundle\Exception\InvalidArgumentException;
use MWEB\TranslationBundle\Translation\Dumper\XliffDumper;

class XliffDumperTest extends BaseDumperTest
{
    public function testCdataOutput()
    {
        $dumper = $this->getDumper();

        $catalogue = new MessageCatalogue();
        $catalogue->add(Message::create('foo')->setLocaleString('<bar>')->setDesc('<baz>'));
        $expected = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" xmlns:LI="urn:LI:translation" version="1.2">
  <file source-language="en" target-language="" datatype="plaintext" original="not.available">
    <header>
      <tool tool-id="MWEBTranslationBundle" tool-name="MWEBTranslationBundle" tool-version="1.1.0-DEV"/>
      <note>The source node in most cases contains the sample message as written by the developer. If it looks like a dot-delimitted string such as "form.label.firstname", then the developer has not provided a default message.</note>
    </header>
    <body>
      <trans-unit id="0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33" resname="foo">
        <source><![CDATA[<baz>]]></source>
        <target state="new"><![CDATA[<bar>]]></target>
      </trans-unit>
    </body>
  </file>
</xliff>

EOF;
        $this->assertEquals($expected, $dumper->dump($catalogue, 'messages'));
    }

    protected function getDumper()
    {
        $dumper = new XliffDumper();
        $dumper->setAddDate(false);

        return $dumper;
    }

    protected function getOutput($key)
    {
        if (!is_file($file = __DIR__.'/xliff/'.$key.'.xml')) {
            throw new InvalidArgumentException(sprintf('There is no output for key "%s".', $key));
        }

        // This is very slow for some reason
//         $doc = \DOMDocument::load($file);
//         $this->assertTrue($doc->schemaValidate(__DIR__.'/../../../Resources/schema/xliff-core-1.2-strict.xsd'));

        return file_get_contents($file);
    }
}