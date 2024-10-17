<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    public $pcategoriesPerPage = 5;
    public $categoriesPerPage = 10;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteParentCategoryAction',
        'deleteCategoryAction'
    ];

    public function addParentCategory() {
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModelForm();
    }

    public function createParentCategory() {
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name'
        ],[
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is already exists.'
        ]);

        /** Store new parent category */
        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $saved = $pcategory->save();

        if( $saved ) {
            $this->hideParentCategoryModelForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'New parent category has been created successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function editParentCategory($id) {
        $pcategory = ParentCategory::findOrFail($id);
        $this->pcategory_id = $pcategory->id;
        $this->pcategory_name = $pcategory->name;
        $this->isUpdateParentCategoryMode = true;
        $this->showParentCategoryModelForm();
    }

    public function updateParentCategory() {
        $pcategory = ParentCategory::findOrFail($this->pcategory_id);

        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name,'.$pcategory->id
        ], [
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is taken.'
        ]);

        /** Update parent category */
        $pcategory->name = $this->pcategory_name;
        $pcategory->slug = null;
        $updated = $pcategory->save();

        if($updated) {
            $this->hideParentCategoryModelForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Parent category has been updated successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function updateParentCategoryOrdering($positions)  {
        // dd($positions);
        foreach($positions as $position) {
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id', $index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Parent categories ordering have been updated successfully.']);
        }
    }

    public function updateCategoryOrdering($positions) {
        foreach($positions as $position) {
            $index = $position[0];
            $new_position = $position[1];
            Category::where('id', $index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Categories ordering have been updated successfully.']);
        }
    }

    public function deleteParentCategory($id)  {
        $this->dispatch('deleteParentCategory', ['id' => $id]);
    }

    public function deleteParentCategoryAction($id) {
        $pcategory = ParentCategory::findOrFail($id);

        // Check if this parent category as children
        if( $pcategory->children->count() > 0 ) {
            foreach( $pcategory->children as $category ) {
                // Release a category
                Category::where('id', $category->id)->delete();
            }
        }

        // Delete parent category
        $delete = $pcategory->delete();

        if( $delete ) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Pareent category has been deleted successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function deleteCategory($id)
    {
        $this->dispatch('deleteCategory', ['id' => $id]);
    }

    public function addCategory() {
        // dd('Show add category modal form...');
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->isUpdateCategoryMode = false;
        $this->showCategoryModelForm();
    }

    public function createCategory() {
        $this->validate([
            'category_name' => 'required|unique:categories,name'
        ], [
            'category_name.required' => 'Category field is required.',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        /** Store new category */
        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $saved = $category->save();

        if( $saved ) {
            $this->hideCategoryModelForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'New category has been created successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function editCategory($id) {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->parent = $category->parent;
        $this->category_name = $category->name;
        $this->isUpdateCategoryMode = true;
        $this->showCategoryModelForm();
    }

    public function updateCategory() {
        $category = Category::findOrFail($this->category_id);
        $this->validate([
            'category_name' => 'required|unique:categories,name,'.$category->id
        ], [
            'category_name.required' => 'Category field is required.',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        /** update category */
        $category->name = $this->category_name;
        $category->parent = $this->parent;
        $category->slug = null;
        $updated = $category->save();

        if( $updated ) {
            $this->hideCategoryModelForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Category has been updated successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function deleteCategoryAction($id) {
        $category = Category::findOrFail($id);

        // Check if this category has related post(s)

        // Delete category
        $delete = $category->delete();

        if( $delete ) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Category has been deleted successfully.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function showParentCategoryModelForm() {
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModelForm() {
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pcategory_id = $this->pcategory_name = null;
    }

    public function showCategoryModelForm() {
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModelForm() {
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'pcategories' => ParentCategory::orderBy('ordering', 'asc')->paginate($this->pcategoriesPerPage, ['*'], 'pcat_page'),
            'categories' => Category::orderBy('ordering', 'asc')->paginate($this->categoriesPerPage, ['*'], 'cat_page')
        ]);
    }
}
