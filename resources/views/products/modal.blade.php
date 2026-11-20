<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-3 col-form-label">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" autoFocus required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="image" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="edit_stock" name="stock" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Image</label>

                        <!-- Preview gambar lama -->
                        <div class="mb-2">
                            <img
                                id="preview_image"
                                src=""
                                alt="Product Image"
                                width="120"
                                class="img-thumbnail">
                        </div>

                        <!-- Input gambar baru -->
                        <input
                            type="file"
                            class="form-control"
                            id="edit_image"
                            name="image"
                            accept="image/png, image/jpeg">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>