{{-- Part of Front project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app         \Windwalker\Web\Application                 Global Application
 * @var $package     \Lyrasoft\Luna\LunaPackage                   Package object.
 * @var $view        \Windwalker\Data\Data                       Some information of this view.
 * @var $uri         \Windwalker\Uri\UriData               Uri information, example: $uri->path
 * @var $datetime    \DateTime                                   PHP DateTime object of current time.
 * @var $helper      \Windwalker\Core\View\Helper\Set\HelperSet  The Windwalker HelperSet object.
 * @var $router      \Windwalker\Core\Router\MainRouter          Route builder object.
 * @var $asset       \Windwalker\Core\Asset\AssetManager         The Asset manager.
 *
 * View variables
 * --------------------------------------------------------------
 * @var $items       \Windwalker\Data\DataSet
 * @var $item        \Lyrasoft\Luna\Admin\Record\ArticleRecord
 * @var $category    \Lyrasoft\Luna\Admin\Record\CategoryRecord
 * @var $state       \Windwalker\Structure\Structure
 * @var $pagination  \Windwalker\Core\Pagination\Pagination
 */
?>

@extends('_global.html')

@section('content')
    <div class="container category-item mt-5">
        @if ($category->notNull())
            <h2 class="mb-4">{{ $category->title }}</h2>
        @endif
        <div class="articles-items">
            @foreach ($items as $i => $item)
                <div class="article-item card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="article-image col-lg-3 mb-3">
                                <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                    class="img-fluid rounded">
                            </div>
                            <div class="article-body col-lg">
                                <h2>
                                    <a href="{{ $item->link }}">
                                        {{ $item->title }}
                                    </a>
                                </h2>

                                <span class="text-muted">
                                    {{ \Windwalker\Core\DateTime\Chronos::toLocalTime($item->created) }}
                                </span>

                                <div class="article-content">
                                    {!! $item->introtext !!}
                                </div>

                                <hr/>

                                @if (property_exists($item, 'comments'))
                                    {{ $item->comments }} Comment(s)

                                    @foreach ($item->tags as $tagItem)
                                        <a class="badge badge-info label label-info"
                                            href="{{ $router->route('article_tag', ['tag' => $tagItem->alias]) }}">
                                            {{ $tagItem->title }}
                                        </a>
                                        &nbsp;
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <hr/>
        <div class="pagination">
            @if ($category->notNull())
                {!! $pagination->route('article_category', ['path' => $category->path])->render() !!}
            @elseif ($tag->notNull())
                {!! $pagination->route('article_tag', ['tag' => $tag->alias])->render() !!}
            @else
                {{-- Home route --}}
            @endif
        </div>
    </div>
@stop
