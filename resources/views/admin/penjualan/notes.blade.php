<div class="modal fade" id="modal-notes{{$item->id_penjualan}}" tabindex="-1" role="dialog" aria-labelledby="modal-notes">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Notes: </h4>
            </div>

            <div class="modal-body">
                <span>
                  {{ $item->notes }}
                </span>
            </div>
        </div>

    </div>
</div>
