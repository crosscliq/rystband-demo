<?php

namespace Ddeboer\DataImport\Tests;

use Ddeboer\DataImport\Reader\ArrayReader;
use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\Writer\CallbackWriter;

class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCallbackFilter()
    {
        $this->getWorkflow()->addFilter(new CallbackFilter(function () {
            return true;
        }));
    }

    public function testAddCallbackValueConverter()
    {
        $this->getWorkflow()->addValueConverter('someField', new CallbackValueConverter(function($input) {
            return str_replace('-', '', $input);
        }));
    }

    public function testAddCallbackItemConverter()
    {
        $this->getWorkflow()->addItemConverter(new CallbackItemConverter(function(array $input) {
            foreach ($input as $k=>$v) {
                if (!$v) {
                    unset($input[$k]);
                }
            }

            return $input;
        }));
    }

    public function testAddCallbackWriter()
    {
        $this->getWorkflow()->addWriter(new CallbackWriter(function($item) {
//            var_dump($item);
        }));
    }

    public function testWriterIsPreparedAndFinished()
    {
        $writer = $this->getMockBuilder('\Ddeboer\DataImport\Writer\CallbackWriter')
            ->disableOriginalConstructor()
            ->getMock();

        $writer->expects($this->once())
            ->method('prepare');

        $writer->expects($this->once())
            ->method('finish');

        $this->getWorkflow()->addWriter($writer)
            ->process();
    }

    public function testMappingAnItem()
    {
        $originalData = array(array('foo' => 'bar'));

        $ouputTestData = array();

        $writer = new ArrayWriter($ouputTestData);
        $reader = new ArrayReader($originalData);

        $workflow = new Workflow($reader);

        $workflow->addMapping('foo', 'bar')
            ->addWriter($writer)
            ->process()
        ;

        $this->assertArrayHasKey('bar', $ouputTestData[0]);
    }

    public function testMapping()
    {
        $originalData = array(array(
            'foo' => 'bar',
            'baz' => array('another' => 'thing')
        ));

        $ouputTestData = array();

        $writer = new ArrayWriter($ouputTestData);
        $reader = new ArrayReader($originalData);

        $workflow = new Workflow($reader);

        $workflow->addMapping('foo', 'bazinga')
            ->addMapping('baz', array('another' => 'somethingelse'))
            ->addWriter($writer)
            ->process()
        ;

        $this->assertArrayHasKey('bazinga', $ouputTestData[0]);
        $this->assertArrayHasKey('somethingelse', $ouputTestData[0]['baz']);
    }

    public function testWorkflowWithObjects()
    {
        $reader = new ArrayReader(array(
            new Dummy('foo'),
            new Dummy('bar'),
            new Dummy('foobar'),
        ));

        $data = array();
        $writer = new ArrayWriter($data);

        $workflow = new Workflow($reader);
        $workflow->addWriter($writer);
        $workflow->addItemConverter(new CallbackItemConverter(function($item) {
            return array('name' => $item->name);
        }));
        $workflow->addValueConverter('name', new CallbackValueConverter(function($name) {
            return strrev($name);
        }));
        $workflow->process();

        $this->assertEquals(array(
            array('name' => 'oof'),
            array('name' => 'rab'),
            array('name' => 'raboof')
        ), $data);
    }

    /**
     * @expectedException \Ddeboer\DataImport\Exception\UnexpectedTypeException
     */
    public function testItemConverterWhichReturnObjects()
    {
        $reader = new ArrayReader(array(
            new Dummy('foo'),
            new Dummy('bar'),
            new Dummy('foobar'),
        ));

        $data = array();
        $writer = new ArrayWriter($data);

        $workflow = new Workflow($reader);
        $workflow->addWriter($writer);
        $workflow->addItemConverter(new CallbackItemConverter(function($item) {
            return $item;
        }));

        $workflow->process();
    }

    /**
     * @expectedException \Ddeboer\DataImport\Exception\UnexpectedTypeException
     */
    public function testItemConverterWithObjectsAndNoItemConverters()
    {
        $reader = new ArrayReader(array(
            new Dummy('foo'),
            new Dummy('bar'),
            new Dummy('foobar'),
        ));

        $data = array();
        $writer = new ArrayWriter($data);

        $workflow = new Workflow($reader);
        $workflow->addWriter($writer);

        $workflow->process();
    }

    public function testFilterPriority()
    {
        $offsetFilter = $this->getMockBuilder('\Ddeboer\DataImport\Filter\OffsetFilter')
            ->disableOriginalConstructor()
            ->setMethods(array('filter'))
            ->getMock();
        $offsetFilter->expects($this->never())->method('filter');

        $validatorFilter = $this->getMockBuilder('\Ddeboer\DataImport\Filter\ValidatorFilter')
            ->disableOriginalConstructor()
            ->setMethods(array('filter'))
            ->getMock();
        $validatorFilter->expects($this->exactly(2))
            ->method('filter')
            ->will($this->returnValue(false));

        $this->getWorkflow()
            ->addFilter($offsetFilter)
            ->addFilter($validatorFilter)
            ->process();
    }

    public function testFilterPriorityOverride()
    {
        $offsetFilter = $this->getMockBuilder('\Ddeboer\DataImport\Filter\OffsetFilter')
            ->disableOriginalConstructor()
            ->setMethods(array('filter'))
            ->getMock();
        $offsetFilter->expects($this->exactly(2))
            ->method('filter')
            ->will($this->returnValue(false));

        $validatorFilter = $this->getMockBuilder('\Ddeboer\DataImport\Filter\ValidatorFilter')
            ->disableOriginalConstructor()
            ->setMethods(array('filter'))
            ->getMock();
        $validatorFilter->expects($this->never())->method('filter');

        $this->getWorkflow()
            ->addFilter($offsetFilter, 257)
            ->addFilter($validatorFilter)
            ->process();
    }

    public function testFilterExecution()
    {
        $result = array();
        $workflow = $this->getWorkflow();
        $workflow
            ->addWriter(new ArrayWriter($result))
            ->addFilter(new CallbackFilter(function ($item) {
                return 'James' === $item['first'];
            }))
            ->process()
        ;

        $this->assertCount(1, $result);
    }

    protected function getWorkflow()
    {
        $reader = new ArrayReader(array(
            array(
                'first' => 'James',
                'last'  => 'Bond'
            ),
            array(
                'first' => 'Miss',
                'last'  => 'Moneypenny'
            )
        ));

        return new Workflow($reader);
    }
}

class Dummy
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}
