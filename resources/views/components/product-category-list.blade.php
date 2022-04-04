<section class="panel">
    <header class="panel-heading">
        Category
    </header>
    <div class="panel-body">
        {{ $list }}
        <div class="text-right">
            <button class="btn btn-primary mt-3" type="button" wire:click.prevent="resetFilterCategory">Reset</button>
        </div>
    </div>
</section>
