<?php

namespace SilverStripe\MultiValueField\Test;

use SilverStripe\MultiValueField\Forms\MultiValueField;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;

/**
 * @author Marcus Nyeholt <marcus@silverstripe.com.au>
 */
class MultiValueFieldTest extends SapphireTest {

	protected $extraDataObjects = array(
		'MultiValueFieldTest_DataObject'
	);

	public function testMultiValueField() {
		$first = array('One', 'Two', 'Three');

		$obj = new MultiValueFieldTest_DataObject();
		$obj->MVField = $first;
		$obj->write();

		$this->assertTrue($obj->isInDB());
		$obj = DataObject::get_by_id('MultiValueFieldTest_DataObject', $obj->ID);

		$this->assertNotNull($obj->MVField);
		$this->assertEquals($first, $obj->MVField->getValues());

		$second = array('Four', 'Five');
		$obj->MVField = $second;
		$obj->write();

		$this->assertEquals($second, $obj->MVField->getValues());
	}

	public function testIsChanged() {
		$field = new MultiValueField();
		$this->assertFalse($field->isChanged());

		$field->setValue(array(1, 2, 3));
		$this->assertTrue($field->isChanged());

		$field = new MultiValueField();
		$field->setValue(array(1, 2, 3), null, false);
		$this->assertFalse($field->isChanged());

		$field = DBField::create_field('SilverStripe\\MultiValueField\\Forms\\MultiValueField', array(1, 2, 3));
		$field->setValue(null);
		$this->assertTrue($field->isChanged());
	}

}

/**
 * @ignore
 */
class MultiValueFieldTest_DataObject extends DataObject implements TestOnly {

	private static $db = array(
		'MVField' => 'MultiValueField'
	);

}
