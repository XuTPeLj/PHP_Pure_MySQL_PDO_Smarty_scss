{extends file="layout.tpl"}

{block name=content}
    <article class="article-page">
        {if $article.image}
            <div class="article-page__image-wrap">
                <img src="{$article.image}" alt="{$article.title}" class="article-page__image">
            </div>
        {/if}

        <h1 class="article-page__title">{$article.title}</h1>

        <div class="article-page__meta">
            <span class="meta__date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
        </div>

        {if $article.categories|count > 0}
            <div class="article-page__categories">
                {foreach $article.categories as $cat}
                    <a href="/category/{$cat.id}" class="tag">{$cat.name}</a>
                {/foreach}
            </div>
        {/if}

        {if $article.description}
            <div class="article-page__description">
                <p>{$article.description}</p>
            </div>
        {/if}

        <div class="article-page__body">
            {$article.body nofilter}
        </div>
    </article>

    {if $related|count > 0}
        <section class="related">
            <h2 class="related__title">Похожие статьи</h2>
            <div class="article-grid">
                {foreach $related as $relArticle}
                    {include file="partials/article_card.tpl" article=$relArticle}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
