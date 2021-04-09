{**
 * plugins/generic/inlineHtmlGalley/blockHowToCite.tpl
 *
 * Copyright (c) University of Pittsburgh
 * Distributed under the GNU GPL v2 or later. For full terms see the file docs/COPYING.
 *
 * Inline HTML Galley How To Cite block
 *
 *}
{* How to cite *}
{if $citation}
    <div class="pkp_block block_inline_html_how_to_cite">
        <span class="title citation_format_label">
            {translate key="submission.howToCite"}
        </span>
        <div class="content">
            <div class="item citation">
                <div class="sub_item citation_display">
                    <div class="citation_format_value">
                        <div id="citationOutput" role="region" aria-live="polite">
                            {$citation}
                        </div>
                        <div class="citation_formats dropdown">
                            <a class="btn btn-primary" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                {translate key="submission.howToCite.citationFormats"}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdown-cit">
                                {foreach from=$citationStyles item="citationStyle"}
                                    <a
                                            class="dropdown-cite-link dropdown-item"
                                            aria-controls="citationOutput"
                                            href="{url page="citationstylelanguage" op="get" path=$citationStyle.id params=$citationArgs}"
                                            data-load-citation
                                            data-json-href="{url page="citationstylelanguage" op="get" path=$citationStyle.id params=$citationArgsJson}"
                                    >
                                        {$citationStyle.title|escape}
                                    </a>
                                {/foreach}
                                {if count($citationDownloads)}
                                    <div class="dropdown-divider"></div>
                                    <h4 class="download-cite">
                                        {translate key="submission.howToCite.downloadCitation"}
                                    </h4>
                                    {foreach from=$citationDownloads item="citationDownload"}
                                        <a class="dropdown-item"
                                            href="{url page="citationstylelanguage" op="download" path=$citationDownload.id params=$citationArgs}">
                                            <span class="fa fa-download"></span>
                                            {$citationDownload.title|escape}
                                        </a>
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}