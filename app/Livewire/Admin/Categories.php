<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    protected $listeners = [
        'updateCategoryOrdering'
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

    public function updateCategoryOrdering($positions)  {
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

    public function deleteParentCategory($id)  {
        $this->dispatch('deleteParentCategory', ['id' => $id]);
    }

    public function deleteCategoryAction($id) {
        $pcategory = ParentCategory::findOrFail($id);

        // Check if this parent category as children

        // Delete parent category
        $delete = $pcategory->delete();

        if( $delete ) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Pareent category has been deleted successfully.']);
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

    public function render()
    {
        return view('livewire.admin.categories', [
            'pcategories' => ParentCategory::orderBy('ordering', 'asc')->get()
        ]);
    }
}
