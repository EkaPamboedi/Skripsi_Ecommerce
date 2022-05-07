<div class="modal fade" id="QRCode{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
           <h3 class="modal-title"><b>Meja nomer {{$user->no_meja}}</b></h3>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4> -->
      </div>
      <div class="modal-body">
        <div class="text-center">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(400)->generate($user->qr_code)) !!} ">
        <br><button class="btn btn-warning btn-flat" onclick="printQR('{{ route('print.Qr', $user->id) }}', 'Print Qr')">Print QR</button>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
