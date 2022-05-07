<div class="modal fade" id="DetailItem" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-md" role="document">
        <form action="" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">Piilih nomer meja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                 <div class="modal-body">
                    <!-- <div class="form-group row">
                        <label for="name" class="col-lg-3 col-lg-offset-1 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                    <!-- <div class="form-group row">
                        <label for="email" class="col-lg-3 col-lg-offset-1 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                    <!-- <div class="form-group row">
                        <label for="password" class="col-lg-3 col-lg-offset-1 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password" id="password" class="form-control"
                            required
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                    <!-- <div class="form-group row">
                        <label for="password_confirmation" class="col-lg-3 col-lg-offset-1 control-label">Konfirmasi Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                required
                                data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="no_meja" class="col-sm-3 col-sm-offset-1 control-label">No Meja</label>
                        <div class="col-sm-6">
                          <input type="number" min="1" name="no_meja" value="">
                          <!-- <select id="no_meja" name="no_meja" class="form-control">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="5">6</option>
                                  <option value="5">7</option>
                                  <option value="5">8</option>
                                  <option value="5">9</option>
                                  <option value="5">10</option>
                                </select> -->
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="level" class="col-lg-3 col-lg-offset-1 control-label">Role</label>
                        <div class="col-lg-6">
                          <select id="level" name="level" class="form-control">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
