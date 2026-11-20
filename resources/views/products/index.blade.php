@extends('templates.layoutApp')

@push('style')
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/tabulator-tables@6.6.1/dist/css/tabulator_bootstrap5.min.css"
  crossorigin="anonymous" />

@endpush
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6">
        <h1 class="mb-0 fs-3">Starter Page</h1>
      </div>
      <div class="col-sm-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Starter Page</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-12">
        <!--begin::Card-->
        <div class="app-content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#createProductModal">
                  <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                  PRODUCT
                </button>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 16rem">
                    <span class="input-group-text">
                      <i class="bi bi-search" aria-hidden="true"></i>
                    </span>
                    <input
                      id="table-filter"
                      type="search"
                      class="form-control"
                      placeholder="Filter rows&hellip;"
                      aria-label="Filter rows" />
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex gap-2 mb-3">
                  <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                    Export CSV
                  </button>
                  <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                    Export JSON
                  </button>
                  <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                    Print
                  </button>
                </div>
                <div id="users-table" aria-label="Users"></div>
                <div
                  id="table-pagination"
                  class="d-flex flex-wrap gap-2 justify-content-end mt-2"></div>
              </div>
              <div class="card-footer bg-body text-body-secondary small">
                Powered by
                <a href="https://tabulator.info/" target="_blank" rel="noopener">Tabulator</a>
                &mdash; vanilla JS, no jQuery required.
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::App Content-->
  @endsection

  @section('modal')
  @include('products.modal')
  @endsection

  @push('scripts')
  <script
    src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.6.1/dist/js/tabulator.min.js"
    crossorigin="anonymous"></script>
  <script>
    const statusBadge = (cell) => {
      const value = cell.getValue();
      const map = {
        Active: 'success',
        Invited: 'info',
        Suspended: 'secondary'
      };
      const color = map[value] || 'secondary';
      return `<span class="badge text-bg-${color}">${value}</span>`;
    };

    function editProduct(id) {

      // Mengambil data produk berdasarkan ID
      fetch("{{ url('products') }}/" + id + "/edit")
        .then(response => response.json())
        .then(product => {

          // Mengisi input dengan data produk
          document.getElementById('edit_name').value = product.name;
          document.getElementById('edit_price').value = product.price;
          document.getElementById('edit_stock').value = product.stock;
          document.getElementById('edit_description').value = product.description;

          // Menampilkan gambar produk sebelumnya
          document.getElementById('preview_image').src =
            product.image ?
            "{{ asset('storage') }}/" + product.image :
            "";

          // Menentukan alamat tujuan form update
          document.getElementById('editProductForm').action =
            "{{ url('products') }}/" + id;

          // Menampilkan modal edit
          const modal = new bootstrap.Modal(
            document.getElementById('editProductModal')
          );

          modal.show();
        })
        .catch(error => {
          console.error('Detail error:', error);
          alert('Terjadi kesalahan: ' + error.message);
        });
    }

    function deleteProduct(id) {

      // Konfirmasi sebelum menghapus
      if (confirm('Apakah kamu yakin ingin menghapus produk ini?')) {

        // Mengirim permintaan DELETE ke Laravel
        fetch("{{ url('products') }}/" + id, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          })

          .then(response => response.json())

          .then(result => {

            if (result.success) {
              alert(result.message);

              // Memuat ulang data Tabulator
              const table = Tabulator.findTable('#users-table')[0];
              table.setData();
            }

          })

          .catch(error => {
            console.error('Gagal menghapus produk:', error);
            alert('Produk gagal dihapus!');
          });
      }
    }
    document.addEventListener('DOMContentLoaded', () => {

      const table = new Tabulator('#users-table', {
        ajaxURL: "{{ route('products.api') }}",
        layout: 'fitColumns',
        filterMode: 'local',
        pagination: 'local',
        paginationElement: document.getElementById('table-pagination'),
        paginationSize: 10,
        paginationSizeSelector: [10, 25, 50, 100],
        movableColumns: true,
        columns: [{
            title: 'ID',
            field: 'id',
            width: 80,
            headerSort: true
          },
          {
            title: 'Product Name',
            field: 'name',
          },
          {
            title: 'Price',
            field: 'price',
          },
          {
            title: 'Stock',
            field: 'stock',
            width: 120,
          },
          {
            title: 'Aksi',
            field: 'id',
            formatter: function(cell) {
              var id = cell.getValue();
              var editUrl = "{{ url('products') }}/" + id + "/edit";

              return `
                <button
                    onclick="editProduct(${id})"
                    class="btn btn-sm btn-success">
                    Edit
                </button>

                <button
                    onclick="deleteProduct(${id})"
                    class="btn btn-sm btn-danger">
                    Hapus
                </button>
            `;
            },
            headerSort: false,
            borderless: true,

            width: 200,
            hozAlign: 'center',
          },
        ],
      });

      table.on('tableBuilt', () => {
        // Keep the scroll region keyboard reachable inside a valid grid.
        // Pagination lives outside the grid so its buttons are not grid rows.
        const grid = document.getElementById('users-table');
        grid.removeAttribute('aria-owns');
        grid.querySelector('.tabulator-tableholder').setAttribute('role', 'rowgroup');
        grid.querySelector('.tabulator-table').setAttribute('role', 'presentation');
      });

      table.on('renderComplete', () => {
        document.querySelectorAll('#table-pagination button').forEach((button) => {
          button.classList.add('btn', 'btn-sm', 'btn-outline-secondary');
        });
      });

      document.getElementById('table-filter').addEventListener('input', (e) => {
        const value = e.target.value;
        if (value) {
          table.setFilter([
            [{
              field: 'name',
              type: 'like',
              value: value
            }, ],
          ]);
        } else {
          table.clearFilter();
        }
      });

      document
        .getElementById('export-csv')
        .addEventListener('click', () => table.download('csv', 'users.csv'));
      document
        .getElementById('export-json')
        .addEventListener('click', () => table.download('json', 'users.json'));
      document
        .getElementById('print-table')
        .addEventListener('click', () => table.print(false, true));
    });
  </script>
  @endpush