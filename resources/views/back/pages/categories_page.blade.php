@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title here')
@section('content')

    @livewire('admin.categories')

@endsection

@push('scripts')
    <script>
        window.addEventListener('showParentCategoryModalForm', function() {
            $('#pcategory_modal').modal('show');
        });

        window.addEventListener('hideParentCategoryModalForm', function() {
            $('#pcategory_modal').modal('hide');
        });

        $('table tbody#sortable_parent_categories').sortable({
            cursor:"move",
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if( $(this).attr('data-ordering') != (index + 1)) {
                        $(this).attr('data-ordering', (index+1)).addClass('updated');
                    }
                });
                var positions = [];
                $('.updated').each(function() {
                    positions.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
                    $(this).removeClass('updated');
                });

                // alert(positions);
                Livewire.dispatch('updateCategoryOrdering', [positions]);
            }
        });

        window.addEventListener('deleteParentCategory', function(event) {
            var id = event.detail[0].id;
            // $().konfirma({
            //     title: 'Are you sure?',
            //     html: 'You want to delete this parent category.',
            //     cancelButtonText:'Cancel',
            //     confirmButtonText:'Yes, Delete',
            //     cancelButtonColor:'#d33',
            //     confirmButtonColor: '#3085d6',
            //     width:320,
            //     allowOutsideClick:false,
            //     fontSize:'1rem',
            //     done: function() {
            //         alert('delete now!');
            //     }
            // });
            Swal.fire({
                title: "Are you sure?",
                html: "You want to delete this parent category.",
                icon: "warning",
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete"
            }).then((result) => {
                alert('delete now!');
                Livewire.dispatch('deleteCategoryAction', [id]);

                if (result.isConfirmed) {
                    alert('delete now!');
                //     Swal.fire({
                //         title: "Deleted!",
                //         text: "Your file has been deleted.",
                //         icon: "success"
                //     });
                }
            });
        });
    </script>
@endpush
