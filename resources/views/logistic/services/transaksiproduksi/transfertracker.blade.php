@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="card mt-3 p-2">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <button class="btn btn-sm btn-red text-white"
                                    onclick="window.location='{{ url('/services/transaksiproduksi/transfer') }}'"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 12 22"
                                        fill="none">
                                        <path d="M11 1L1 11L11 21" stroke="#ffffff" stroke-opacity="0.8" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> Transfer</button>
                                <h3 class="text-center m-0 h3-0">Tracker Posisi Work Order</h3>
                                <form
                                    action="{{ url('/services/transaksiproduksi/transfer/lacak/update/' . $transfer->no_bon) }}"
                                    method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-sm btn-red text-white" di
                                        {{ $transfer->status == 6 ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            viewBox="0 0 15 15">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                d="M1.903 7.297c0 3.044 2.207 5.118 4.686 5.547a.521.521 0 1 1-.178 1.027C3.5 13.367.861 10.913.861 7.297c0-1.537.699-2.745 1.515-3.663c.585-.658 1.254-1.193 1.792-1.602H2.532a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V2.686l-.001.002c-.572.43-1.27.957-1.875 1.638c-.715.804-1.253 1.776-1.253 2.97Zm11.108.406c0-3.012-2.16-5.073-4.607-5.533a.521.521 0 1 1 .192-1.024c2.874.54 5.457 2.98 5.457 6.557c0 1.537-.699 2.744-1.515 3.663c-.585.658-1.254 1.193-1.792 1.602h1.636a.5.5 0 1 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 1 1 1 0v1.845h.002c.571-.432 1.27-.958 1.874-1.64c.715-.803 1.253-1.775 1.253-2.97Z"
                                                clip-rule="evenodd" />
                                        </svg> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body text-center text-secondary">
                            <table class="table table-borderless">
                                <tr>
                                    <div class="row my-5">
                                        <div
                                            class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 1 ? 'text-red' : '' }}">
                                            <span>
                                                <p class="p-0 m-0">COIL</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->created_at->format('d-m-Y H:i:s') }}</p>
                                            </span>
                                        </div>
                                        <div
                                            class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 2 ? 'text-red' : '' }}">
                                            <span>
                                                <p class="p-0 m-0">CORE COIL ASSEMBLY</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->updated_at && $transfer->status >= 2 ? $transfer->updated_at->format('d-m-Y H:i:s') : '' }}
                                                </p>
                                            </span>
                                        </div>
                                        <div
                                            class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 3 ? 'text-red' : '' }}">
                                            <span>
                                                <p class="p-0 m-0">
                                                    CONNECTION
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->updated_at && $transfer->status >= 3 ? $transfer->updated_at->format('Y-m-d H:i:s') : '' }}
                                                </p>
                                            </span>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="row mt-5">
                                        <div
                                            class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 4 ? 'text-red' : '' }}">
                                            <span>
                                                <p class="p-0 m-0">FINAL</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->updated_at && $transfer->status >= 4 ? $transfer->updated_at->format('d-m-Y H:i:s') : '' }}
                                                </p>

                                            </span>
                                        </div>
                                        <div
                                            class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 5 ? 'text-red' : '' }}">
                                            <span>
                                                <p class="p-0 m-0">FINISHING</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->updated_at && $transfer->status >= 5 ? $transfer->updated_at->format('d-m-Y H:i:s') : '' }}
                                                </p>
                                            </span>
                                        </div>
                                        <div class="col-lg-4 ">
                                            @if (isset($transfer->status) && $transfer->status == 6)
                                                <a href="" class="text-red" data-bs-toggle="modal"
                                                    data-bs-target="#finishgoodModal">
                                                @else
                                                    <span class="text-secondary"></span>
                                            @endif
                                            <span>
                                                <p class="p-0 m-0">QC</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="10" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                                </svg>
                                                <p>{{ $transfer->updated_at && $transfer->status >= 6 ? $transfer->updated_at->format('d-m-Y H:i:s') : '' }}
                                                </p>
                                            </span>
                                            @if (isset($transfer->status) && $transfer->status == 6)
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="finishgoodModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <form
                                                    action="{{ url('/services/transaksiproduksi/transfer/lacak/addStock') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Stok In
                                                                Finishedgood
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <label for="no_bon" class="form-label">No Bon
                                                                            Transfer</label>
                                                                        <input type="text" name="no_bon"
                                                                            id="no_bon"
                                                                            value="{{ $transfer->no_bon }}"
                                                                            class="form-control" readonly>
                                                                        @error('no_bon')
                                                                            <div class="invalid-feedback">
                                                                                <p>{{ $message }}</p>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <label for="id_wo" class="form-label">Referensi
                                                                            (WO)</label>
                                                                        <input type="text" name="id_wo"
                                                                            id="id_wo" value="{{ $transfer->id_wo }}"
                                                                            class="form-control" readonly>
                                                                        @error('id_wo')
                                                                            <div class="invalid-feedback">
                                                                                <p>{{ $message }}</p>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <div class="col-mb-3">
                                                                            <label for="exampleInputName"
                                                                                class="form-label">Kode Finished Good
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                id="kd_finishedgood" readonly
                                                                                name="kd_finishedgood"
                                                                                value="{{ $transfer->wo->id_fg }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <div class="col-mb-3">
                                                                            <label for="exampleInputName"
                                                                                class="form-label">Qty
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                id="qty_trafo" readonly name="qty_trafo"
                                                                                value="{{ $transfer->wo->qty_trafo }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <div class="col-mb-3">
                                                                            <label for="exampleInputName"
                                                                                class="form-label">kVA
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                id="kva" readonly name="kva"
                                                                                value="{{ $transfer->wo->kva }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <label for="nsp"
                                                                            class="form-label ">NSP</label>
                                                                        <input type="input"
                                                                            class="form-control @error('nsp')is-invalid  @enderror"
                                                                            id="nsp" name="nsp"
                                                                            placeholder="nsp"
                                                                            value="{{ old('nsp') }}">
                                                                        @error('nsp')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <label for="nsk"
                                                                            class="form-label ">NSK</label>
                                                                        <input type="input"
                                                                            class="form-control @error('nsk') is-invalid @enderror"
                                                                            id="nsk" name="nsk"
                                                                            placeholder="nsk"
                                                                            value="{{ old('nsk') }}">
                                                                        @error('nsk')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3 p-2">
                                                                        <label for="gudang"
                                                                            class="form-label">Gudang</label>
                                                                        <select name="gudang" id="gudang"
                                                                            onchange="dataWo(this)"
                                                                            class="form-control @error('gudang') is-invalid @enderror">
                                                                            <option>Pilih Gudang</option>
                                                                            @foreach ($gudang as $item)
                                                                                <option value="{{ $item->nama_gudang }}">
                                                                                    {{ $item->nama_gudang }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('gudang')
                                                                            <div class="invalid-feedback">
                                                                                <p>{{ $message }}</p>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-sm btn-red">Add Stock
                                                                </button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        </tr>
                        <tr>
                            <div class="row mt-5 justify-content-center">
                                <div
                                    class="col-lg-4 {{ isset($transfer->status) && $transfer->status == 7 ? 'text-red' : '' }}">
                                    <span>
                                        <p class="p-0 m-0">Finshed Good</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 32 32">
                                            <circle cx="16" cy="16" r="10" fill="currentColor" />
                                            <path fill="currentColor"
                                                d="M16 30a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14Zm0-26a12 12 0 1 0 12 12A12.014 12.014 0 0 0 16 4Z" />
                                        </svg>
                                        <p>{{ $transfer->updated_at && $transfer->status >= 7 ? $transfer->updated_at->format('d-m-Y H:i:s') : '' }}
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
