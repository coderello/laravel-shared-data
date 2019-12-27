<?php

namespace Coderello\SharedData\Tests;

use Coderello\SharedData\SharedData;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use stdClass;

class SharedDataTest extends AbstractTestCase
{
    /** @var SharedData|null */
    protected $sharedData;

    /** @var mixed|null */
    protected $lazy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sharedData = new SharedData;

        $this->lazy = null;
    }

    public function testPut()
    {
        // scalar

        $this->sharedData->put('foo', 'bar');

        $this->assertSame('bar', $this->sharedData->get('foo'));

        // iterable

        $this->sharedData->put([
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ]);

        $this->assertSame('scalar-value', $this->sharedData->get('scalar'));

        $this->assertSame(['nested' => 'value'], $this->sharedData->get('array'));

        // JsonSerializable

        $jsonSerializable = new class implements JsonSerializable {
            public function jsonSerialize()
            {
                return [
                    'json-serializable-key' => 'json-serializable-value',
                ];
            }
        };

        $this->sharedData->put($jsonSerializable);

        $this->assertSame('json-serializable-value', $this->sharedData->get('json-serializable-key'));

        // Arrayable

        $arrayable = new class implements Arrayable {
            public function toArray()
            {
                return [
                    'arrayable-key' => 'arrayable-value',
                ];
            }
        };

        $this->sharedData->put($arrayable);

        $this->assertSame('arrayable-value', $this->sharedData->get('arrayable-key'));

        // Closure (lazy)

        $this->lazy = 'foo';

        $this->sharedData->put(function () {
            return [
                'lazy' => $this->lazy,
            ];
        });

        $this->lazy = 'bar';

        $this->assertSame('bar', $this->sharedData->get('lazy'));

        // Closure (lazy) with key

        $this->lazy = 'foo';

        $this->sharedData->put('lazy-with-key', function () {
            return $this->lazy;
        });

        $this->lazy = 'bar';

        $this->assertSame('bar', $this->sharedData->get('lazy-with-key'));

        // object

        $object = new stdClass;

        $object->objectScalar = 'object-scalar';

        $object->objectArray = ['nested' => 'object-scalar'];

        $this->sharedData->put($object);

        $this->assertSame('object-scalar', $this->sharedData->get('objectScalar'));

        $this->assertSame(['nested' => 'object-scalar'], $this->sharedData->get('objectArray'));
    }

    public function testGet()
    {
        $values = [
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ];

        $this->sharedData->put($values);

        $this->assertSame('scalar-value', $this->sharedData->get('scalar'));

        $this->assertSame($values, $this->sharedData->get());
    }

    public function testToJson()
    {
        $this->sharedData->put([
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ]);

        $json = $this->sharedData->toJson();

        $expectedJson = '{"scalar":"scalar-value","array":{"nested":"value"}}';

        $this->assertSame($expectedJson, $json);
    }

    public function testRender()
    {
        $this->sharedData->put([
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ]);

        $this->sharedData->setJsNamespace('foo');

        $html = $this->sharedData->render();

        $expectedHtml = '<script>window[\'foo\']={"scalar":"scalar-value","array":{"nested":"value"}};window[\'sharedDataNamespace\']=\'foo\';</script>';

        $this->assertSame($expectedHtml, $html);
    }

    public function testToString()
    {
        $this->sharedData->put('foo', 'bar');

        $this->assertSame($this->sharedData->render(), (string) $this->sharedData);
    }

    public function testJsNamespace()
    {
        $this->assertSame('sharedData', $this->sharedData->getJsNamespace());

        $this->sharedData->setJsNamespace('foo');

        $this->assertSame('foo', $this->sharedData->getJsNamespace());
    }

    public function testToArray()
    {
        $this->sharedData->put('foo', ['bar' => 'baz']);

        $this->assertSame(['foo' => ['bar' => 'baz']], $this->sharedData->toArray());
    }

    public function testJsonSerialize()
    {
        $this->sharedData->put('foo', ['bar' => 'baz']);

        $this->assertSame(['foo' => ['bar' => 'baz']], $this->sharedData->jsonSerialize());
    }

    public function testOffsetExists()
    {
        $this->sharedData->put('foo.baz', 'bar');

        $this->assertTrue(isset($this->sharedData['foo.baz']));

        $this->assertFalse(isset($this->sharedData['baz.foo']));
    }

    public function testOffsetGet()
    {
        $this->sharedData->put('foo.bar', 'baz');

        $this->assertSame('baz', $this->sharedData['foo.bar']);
    }

    public function testOffsetSet()
    {
        $this->sharedData['foo.bar'] = 'baz';

        $this->assertSame(
            [
                'foo' => [
                    'bar' => 'baz',
                ],
            ],
            $this->sharedData->get()
        );
    }

    public function testOffsetUnset()
    {
        $this->sharedData->put([
            'foo' => [
                'bar' => 'baz',
                'baz' => 'bar',
            ],
        ]);

        unset($this->sharedData['foo.baz']);

        $this->assertSame(
            [
                'foo' => [
                    'bar' => 'baz',
                ],
            ],
            $this->sharedData->get()
        );
    }

    public function testForget()
    {
        $this->sharedData->put([
            'foo' => [
                'bar' => 'baz',
                'baz' => 'bar',
            ],
        ]);

        $this->sharedData->forget('foo.baz');

        $this->assertSame(
            [
                'foo' => [
                    'bar' => 'baz',
                ],
            ],
            $this->sharedData->get()
        );

        $this->sharedData->forget();

        $this->assertSame([], $this->sharedData->get());
    }

    public function testDirective()
    {
        $this->assertEquals(
            shared()->render(),
            view('shared')->render()
        );
    }
}
