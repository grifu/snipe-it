<?php
use App\Models\Accessory;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccessoryTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    public function testFailsEmptyValidation()
    {
        // An Accessory requires a name, a qty, and a category_id.
        $a = Accessory::create();
        $this->assertFalse($a->isValid());
        $fields = [
            'name' => 'name',
            'qty' => 'qty',
            'category_id' => 'category id'
        ];
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
        }
    }

    public function testFailsMinValidation()
    {
        // An Accessory name has a min length of 3
        // An Accessory has a min qty of 1
        // An Accessory has a min amount of 0
        $a = factory(Accessory::class)->make([
            'name' => 'a',
            'qty' => 0,
            'min_amt' => -1
        ]);
        $fields = [
            'name' => 'name',
            'qty' => 'qty',
            'min_amt' => 'min amt'
        ];
        $this->assertFalse($a->isValid());
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertContains("The ${fieldTitle} must be at least", $errors->get($field)[0]);
        }
    }

    public function testCategoryIdMustExist()
    {
        $category = $this->createValidCategory('accessory-keyboard-category', ['category_type' => 'accessory']);
        $accessory = factory(Accessory::class)->states('apple-bt-keyboard')->make(['category_id' => $category->id]);
        $this->createValidManufacturer('apple');

        $accessory->save();
        $this->assertTrue($accessory->isValid());
        $newId = $category->id + 1;
        $accessory = factory(Accessory::class)->states('apple-bt-keyboard')->make(['category_id' => $newId]);
        $accessory->save();

        $this->assertFalse($accessory->isValid());
        $this->assertContains("The selected category id is invalid.", $accessory->getErrors()->get('category_id')[0]);
    }

    public function testAnAccessoryBelongsToACompany()
    {
        $accessory = factory(Accessory::class)
            ->create(['company_id' => factory(App\Models\Company::class)->create()->id]);
        $this->assertInstanceOf(App\Models\Company::class, $accessory->company);
    }

    public function testAnAccessoryHasALocation()
    {
        $accessory = factory(Accessory::class)
            ->create(['location_id' => factory(App\Models\Location::class)->create()->id]);
        $this->assertInstanceOf(App\Models\Location::class, $accessory->location);
    }

    public function testAnAccessoryBelongsToACategory()
    {
        $accessory = factory(Accessory::class)->states('apple-bt-keyboard')
            ->create(['category_id' => factory(Category::class)->states('accessory-keyboard-category')->create(['category_type' => 'accessory'])->id]);
        $this->assertInstanceOf(App\Models\Category::class, $accessory->category);
        $this->assertEquals('accessory', $accessory->category->category_type);
    }

    public function testAnAccessoryHasAManufacturer()
    {
        $this->createValidManufacturer('apple');
        $this->createValidCategory('accessory-keyboard-category');
        $accessory = factory(Accessory::class)->states('apple-bt-keyboard')->create(['category_id' => 1]);
        $this->assertInstanceOf(App\Models\Manufacturer::class, $accessory->manufacturer);
    }
}
