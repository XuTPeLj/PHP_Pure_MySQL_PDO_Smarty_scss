{if $totalPages > 1}
    <nav class="pagination">
        {if $currentPage > 1}
            <a href="{$baseUrl}&page={$currentPage - 1}" class="pagination__link pagination__link--prev">&laquo; Назад</a>
        {/if}

        {for $p = 1 to $totalPages}
            {if $p === $currentPage}
                <span class="pagination__link pagination__link--active">{$p}</span>
            {else}
                <a href="{$baseUrl}&page={$p}" class="pagination__link">{$p}</a>
            {/if}
        {/for}

        {if $currentPage < $totalPages}
            <a href="{$baseUrl}&page={$currentPage + 1}" class="pagination__link pagination__link--next">Вперёд &raquo;</a>
        {/if}
    </nav>
{/if}
