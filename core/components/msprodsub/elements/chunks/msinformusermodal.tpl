<div class="modal fade" id="iu-modal" tabindex="-1" role="dialog" aria-labelledby="iu-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="iu-inform" action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{'msinformuser_announce_arrival' | lexicon}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="modal-body row">
                        <div class="col-sm">
                            {if $product.thumb?}
                                <img class="mb-product-img" src="{$product.thumb}" alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                            {else}
                                <img class="mb-product-img" src="{'assets_url' | option}components/minishop2/img/web/ms2_small.png"
                                     srcset="{'assets_url' | option}components/minishop2/img/web/ms2_small@2x.png 2x"
                                     alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                            {/if}

                            <div class="card-body mb-card-body">
                                <h5 class="card-title"><a href="{$product.id | url}">{$product.pagetitle}</a></h5>

                                <span class="flags">
                                    {if $product.new?}
                                        <i class="glyphicon glyphicon-flag" title="{'ms2_frontend_new' | lexicon}"></i>
                                    {/if}
                                    {if $product.popular?}
                                        <i class="glyphicon glyphicon-star" title="{'ms2_frontend_popular' | lexicon}"></i>
                                    {/if}
                                    {if $product.favorite?}
                                        <i class="glyphicon glyphicon-bookmark" title="{'ms2_frontend_favorite' | lexicon}"></i>
                                    {/if}
                                </span>

                                <span class="price">
                                    {$product.price} {'ms2_frontend_currency' | lexicon}
                                </span>
                                {if $product.old_price?}
                                    <span class="old_price">{$product.old_price} {'ms2_frontend_currency' | lexicon}</span>
                                {/if}

                            </div>
                        </div>
                        <div class="col-sm">
                            <input type="hidden" name="iu_val" value="" />
                            <input type="hidden" name="id" value="{$product.id}" />

                            {if $addedArrival OR $removeArrival}
                                <div id="iu-alert" class="alert alert-success" role="alert">
                                    {$iuMessage}
                                </div>
                            {else}
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="iu_email" value="{$user.email}"
                                           placeholder="user@domain.com" required {$disabled} />
                                    <div id="iu-invalid-email" class="invalid-feedback"></div>
                                </div>

                                {if $requestCount}
                                    <div class="form-group">
                                        <label>{'msinformuser_count' | lexicon}</label>
                                        <input type="number" class="form-control" min="1" name="iu_count" value="1" />
                                    </div>
                                {/if}

                                {if $consent}
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="iu-consent-check">
                                        <label class="form-check-label" for="iu-consent-check"><small>{$consent}</small></label>
                                    </div>
                                {/if}
                            {/if}


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{'msinformuser_close' | lexicon}</button>
                    {if $addedArrival}
                        <button type="submit" name="iu_action" class="btn btn-primary" data-iu="iu/remove">
                            {'msinformuser_unsubscribe' | lexicon}
                        </button>
                    {else}
                        {if !$removeArrival}
                            <button type="submit" name="iu_action" id="iu-consent-button" class="btn btn-primary"
                                    data-iu="iu/add{if $requestCount}/count{/if}"{if $consent} disabled{/if}>
                                {'msinformuser_subscribe' | lexicon}
                            </button>
                        {/if}
                    {/if}
                </div>
            </div>
        </form>
    </div>
    <script>
        $('#iu-modal').modal('show');
        $('#iu-modal').on('hidden.bs.modal', function (e) {
            $('#iu-modal').remove();
            $('button[name=iu_action]').attr('disabled', false);
        })
    </script>
</div>