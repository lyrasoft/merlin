{{-- Part of Admin project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app      \Windwalker\Web\Application                 Global Application
 * @var $package  \Windwalker\Core\Package\AbstractPackage    Package object.
 * @var $view     \Windwalker\Data\Data                       Some information of this view.
 * @var $uri      \Windwalker\Uri\UriData               Uri information, example: $uri->path
 * @var $datetime \DateTime                                   PHP DateTime object of current time.
 * @var $helper   \Windwalker\Core\View\Helper\Set\HelperSet  The Windwalker HelperSet object.
 * @var $router   \Windwalker\Core\Router\PackageRouter       Router object.
 *
 * View variables
 * --------------------------------------------------------------
 * @var $item     \Windwalker\Data\Data
 * @var $state    \Windwalker\Structure\Structure
 * @var $form     \Windwalker\Form\Form
 */
?>

@extends($luna->editExtends)

@section('toolbar-buttons')
    @include('toolbar')
@stop

@section('admin-body')
    <form name="admin-form" id="admin-form" action="{{ $router->route('category', ['type' => $type]) }}"
          method="POST" enctype="multipart/form-data">

        @include('luna.form.title-bar')

        <div class="row">
            <div class="col-md-7">
                <fieldset class="form-horizontal">
                    <legend>@translate($luna->langPrefix . 'category.edit.fieldset.basic')</legend>

                    {!! $form->renderFields('basic') !!}
                </fieldset>

                <fieldset class="form-horizontal">
                    <legend>@translate($luna->langPrefix . 'category.edit.fieldset.text')</legend>

                    {!! $form->getField('description')->renderInput() !!}
                </fieldset>
            </div>
            <div class="col-md-5">
                <fieldset class="form-horizontal">
                    <legend>@translate($luna->langPrefix . 'category.edit.fieldset.created')</legend>

                    {!! $form->renderFields('created') !!}
                </fieldset>
            </div>
        </div>

        <div class="hidden-inputs">
            @formToken
        </div>

    </form>
@stop
