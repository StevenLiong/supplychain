{{-- <div class="col-lg-10 col-sm-6 mt-2">
    <form method="post" action="{{ route('update', $product->kd_manhour) }}">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                </div>
                <div class="input-group-append">
                    <input type="text" class="input-group-text font-size-lg bg-warning"
                        id="total_hour" name="total_hour"
                        value="{{ old('total_hour', $product->total_hour) }}" >
                </div>
                <div class="input-group-append">
                    <input type="text" class="input-group-text font-size-lg bg-warning"
                        id="coil_lv" name="coil_lv"
                        value="{{ old('coil_lv', $product->dry_cast_resin->coil_lv) }}" >
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa-regular fa-floppy-disk "></i>Update
                </button>
            </div>
        </div>
    </form>
</div> --}}
<div>
    {{$id}}
</div>
