<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class LocationPresenter
 * @package App\Presenters
 */
class LocationPresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [

            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/locations/table.name'),
                "visible" => true,
                "formatter" => "locationsLinkFormatter"
            ],
            [
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.image'),
                "visible" => true,
                "formatter" => "imageFormatter"
            ],
            [
                "field" => "parent",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/locations/table.parent'),
                "visible" => true,
                "formatter" => "locationsLinkObjFormatter"
            ],

            [
                "field" => "assets_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.assets_rtd'),
                "visible" => true,
            ],
            [
                "field" => "assigned_assets_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.assets_checkedout'),
                "visible" => true,
            ],
            [
                "field" => "users_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('general.people'),
                "visible" => true,
            ],
            [
                "field" => "currency",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('general.currency'),
                "visible" => true,
            ],
            [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.address'),
                "visible" => true,
            ],
            [
                "field" => "city",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.city'),
                "visible" => true,
            ],
            [
                "field" => "state",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.state'),
                "visible" => true,
            ],
            [
                "field" => "zip",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.zip'),
                "visible" => false,
            ],
            [
                "field" => "country",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/locations/table.country'),
                "visible" => false,
            ],[
                "field" => "manager",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/users/table.manager'),
                "visible" => false,
                "formatter" => 'usersLinkObjFormatter'
            ],

            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_at'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],

            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "locationsActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }



    /**
     * Link to this locations name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('locations.show', $this->name, $this->id);
    }

    /**
     * Getter for Polymorphism.
     * @return mixed
     */
    public function name()
    {
        return $this->model->name;
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('locations.show', $this->id);
    }

    public function glyph()
    {
        return '<i class="fa fa-map-marker"></i>';
    }
    
    public function fullName() {
        return $this->name;
    }
}
