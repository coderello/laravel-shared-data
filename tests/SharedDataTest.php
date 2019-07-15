<?php

namespace Coderello\SharedData\Tests;

use Coderello\SharedData\SharedData;

class SharedDataTest extends AbstractTestCase
{
    /**
     * @var \Coderello\SharedData\SharedData instance under test
     */
    protected $sharedData;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->sharedData = $this->app->make(SharedData::class);
    }

    public function testSetupData()
    {
        $this->sharedData->put('foo', 'bar');
        $this->assertSame('bar', $this->sharedData->get('foo'));

        $this->sharedData->put([
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ]);
        $this->assertSame('scalar-value', $this->sharedData->get('scalar'));
        $this->assertSame(['nested' => 'value'], $this->sharedData->get('array'));

        $object = new \stdClass;
        $object->objectScalar = 'object-scalar';
        $object->objectArray = ['nested' => 'object-scalar'];
        $this->sharedData->put($object);
        $this->assertSame('object-scalar', $this->sharedData->get('objectScalar'));
        $this->assertSame(['nested' => 'object-scalar'], $this->sharedData->get('objectArray'));
    }

    /**
     * @depends testSetupData
     */
    public function testGetAll()
    {
        $values = [
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ];

        $this->sharedData->put($values);

        $this->assertSame($values, $this->sharedData->get());
    }

    /**
     * @depends testSetupData
     */
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

    /**
     * @depends testSetupData
     */
    public function testRender()
    {
        $this->sharedData->put([
            'scalar' => 'scalar-value',
            'array' => ['nested' => 'value'],
        ]);

        $html = $this->sharedData->render();
        $expectedHtml = '<script>window[\'sharedData\'] = {"scalar":"scalar-value","array":{"nested":"value"}};</script>';

        $this->assertSame($expectedHtml, $html);
    }

    /**
     * @depends testRender
     */
    public function testToString()
    {
        $this->sharedData->put('foo', 'bar');

        $this->assertSame($this->sharedData->render(), (string) $this->sharedData);
    }

    /**
     * @depends testRender
     */
    public function testStandaloneInstance()
    {
        $sharedData = (new SharedData())
            ->setJsNamespace('testData');

        $this->assertSame('testData', $sharedData->getJsNamespace());

        $html = $sharedData->render();
        $expectedHtml = '<script>window[\'testData\'] = [];</script>';

        $this->assertSame($expectedHtml, $html);
    }
}
