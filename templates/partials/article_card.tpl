<div class="article-card">
    {if $article.image}
        <a href="/article/{$article.id}" class="article-card__image-link">
            <div class="article-card__image-wrap">
                <img src="{$article.image}" alt="{$article.title}" class="article-card__image" loading="lazy">
            </div>
        </a>
    {else}
        <div class="article-card__image-wrap article-card__image-wrap--placeholder">
            <span>Нет изображения</span>
        </div>
    {/if}

    <div class="article-card__content">
        <h3 class="article-card__title">
            <a href="/article/{$article.id}" class="article-card__title-link">{$article.title}</a>
        </h3>
        <span class="article-card__date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
        {if $article.description}
            <p class="article-card__description">{$article.description|truncate:180}</p>
        {/if}
        <a href="/article/{$article.id}" class="article-card__read-more">Читать далее</a>
    </div>
</div>
