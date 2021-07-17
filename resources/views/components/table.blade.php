<div class="row">
    <div class="col-lg-12">
        <div class="d-sm-flex align-items-end justify-content-end mb-4">
            {{ $action }}
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <div class="my-2 d-sm-flex align-items-end justify-content-end">
                    <div class="my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" wire:model.debounce.500ms="searchTerm">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            {{ $header }}
                        </thead>
                        <tbody>
                            {{ $row }}
                        </tbody>
                    </table>
                </div>
                <div class="d-sm-flex align-items-end justify-content-end">
                    {{ $pagination }}
                </div>
            </div>
        </div>
    </div>
</div>
