{{-- Part of Admin project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app           \Windwalker\Web\Application            Global Application
 * @var $package       \Lyrasoft\Luna\LunaPackage           Package object.
 * @var $view          \Windwalker\Data\Data                  Some information of this view.
 * @var $uri           \Windwalker\Uri\UriData          Uri information, example: $uri->path
 * @var $datetime      \DateTime                              PHP DateTime object of current time.
 * @var $helper        \Admin\Helper\MenuHelper        The Windwalker HelperSet object.
 * @var $router        \Windwalker\Core\Router\PackageRouter  Router object.
 *
 * View variables
 * --------------------------------------------------------------
 * @var $filterBar     \Windwalker\Core\Widget\Widget
 * @var $filterForm    \Windwalker\Form\Form
 * @var $form          \Windwalker\Form\Form
 * @var $showFilterBar boolean
 * @var $grid          \Phoenix\View\Helper\GridHelper
 * @var $state         \Windwalker\Structure\Structure
 * @var $items         \Windwalker\Data\DataSet
 * @var $item          \Windwalker\Data\Data
 * @var $i             integer
 * @var $pagination    \Windwalker\Core\Pagination\Pagination
 */
?>

@extends('_global.' . \Lyrasoft\Luna\Helper\LunaHelper::getAdminPackage(true) . '.pure')

@section('toolbar-buttons')
    @include('toolbar')
@stop

@section('body')
    <div id="phoenix-admin" class="modules-container grid-container">
        <form name="admin-form" id="admin-form" action="{{ $uri['full'] }}" method="POST" enctype="multipart/form-data">

            {{-- FILTER BAR --}}
            <div class="filter-bar">
                <button class="btn btn-default pull-right" onclick="parent.{{ $function }}('{{ $selector }}', '', '');">
                    <span class="glyphicon glyphicon-remove fa fa-remove fa-times"></span>
                    @translate('phoenix.grid.modal.button.cancel')
                </button>
                {!! $filterBar->render(array('form' => $form, 'show' => $showFilterBar)) !!}
            </div>

            {{-- RESPONSIVE TABLE DESC --}}
            <p class="visible-xs-block d-sm-block d-md-none">
                @translate('phoenix.grid.responsive.table.desc')
            </p>

            <div class="grid-table table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        {{-- TITLE --}}
                        <th>
                            {!! $grid->sortTitle($luna->langPrefix . 'module.field.title', 'module.title') !!}
                        </th>

                        {{-- STATE --}}
                        <th>
                            {!! $grid->sortTitle($luna->langPrefix . 'module.field.state', 'module.state') !!}
                        </th>

                        {{-- TYPE --}}
                        <th>
                            {!! $grid->sortTitle($luna->langPrefix . 'module.field.type', 'module.type') !!}
                        </th>

                        {{-- POSITION --}}
                        <th>
                            {!! $grid->sortTitle($luna->langPrefix . 'module.field.position', 'module.position') !!}
                        </th>

                        {{-- ID --}}
                        <th>
                            {!! $grid->sortTitle($luna->langPrefix . 'module.field.id', 'module.id') !!}
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $i => $item)
                        <?php
                        $grid->setItem($item, $i);
                        ?>
                        <tr>
                            {{-- TITLE --}}
                            <td class="hasHighlight">
                                <a href="#"
                                   onclick="parent.{{ $function }}('{{ $selector }}', '{{ $item->id }}', '{{ $item->title }}');">
                                    <span
                                        class="glyphicon glyphicon-menu-left fa fa-angle-right text-muted"></span> {{ $item->title }}
                                </a>
                            </td>

                            {{-- STATE --}}
                            <td class="text-center">
                                {!! $grid->published($item->state, array('only_icon' => true)) !!}
                            </td>

                            {{-- TYPE --}}
                            <td>
                                {{ $item->module->name }}
                            </td>

                            {{-- POSITION --}}
                            <td>
                            <span class="{{ $item->labelClass }}">
                                {{ $item->positionName }}
                            </span>
                            </td>

                            {{-- ID --}}
                            <td>
                                {{ $item->id }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr>
                        {{-- PAGINATION --}}
                        <td colspan="25">
                            {!! $pagination->route($view->name, [])->render() !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="hidden-inputs">
                {{-- METHOD --}}
                <input type="hidden" name="_method" value="PUT"/>

                {{-- TOKEN --}}
                @formToken
            </div>

            @include('batch')
        </form>
    </div>
@stop
