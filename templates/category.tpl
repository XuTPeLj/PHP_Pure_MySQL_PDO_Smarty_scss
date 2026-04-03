{extends file="layout.tpl"}

{block name=content}
    <section class="category-page">
        <div class="category-page__header">
            <h1 class="category-page__title">{$category.name}</h1>
            {if $category.description}
                <p class="category-page__description">{$category.description}</p>
            {/if}
        </div>

        <div class="category-page__sorting">
            <span class="sorting__label">Сортировка:</span>
            <a href="/category/{$category.id}?sort=date"
               class="sorting__link{if $sort === 'date'} sorting__link--active{/if}">по дате</a>
            <a href="/category/{$category.id}?sort=views"
               class="sorting__link{if $sort === 'views'} sorting__link--active{/if}">по просмотрам</a>
        </div>

        {if $articles|count > 0}
            <div class="article-grid">
                {foreach $articles as $article}
                    {include file="partials/article_card.tpl" article=$article}
                {/foreach}
            </div>

            {include file="partials/pagination.tpl"
                currentPage=$currentPage
                totalPages=$totalPages
                baseUrl="/category/{$category.id}?sort={$sort}"}
        {else}
            <p class="empty-message">В этой категории пока нет статей.</p>
        {/if}
    </section>
{/block}
