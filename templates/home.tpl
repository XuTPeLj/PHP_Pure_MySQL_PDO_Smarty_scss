{extends file="layout.tpl"}

{block name=content}
    <section class="home">
        {if $categories|count > 0}
            {foreach $categories as $category}
                <section class="category-section">
                    <div class="category-section__header">
                        <h2 class="category-section__title">{$category.name}</h2>
                        <a href="/category/{$category.id}" class="category-section__view-all">Смотреть все</a>
                    </div>

                    {if $category.articles|count > 0}
                        <div class="article-grid">
                            {foreach $category.articles as $article}
                                {include file="partials/article_card.tpl" article=$article}
                            {/foreach}
                        </div>
                    {else}
                        <p class="empty-message">В этой категории пока нет статей.</p>
                    {/if}
                </section>
            {/foreach}
        {else}
            <p class="empty-message">Пока нет опубликованных статей.</p>
        {/if}
    </section>
{/block}
