<x-app-layout page-class="homepage" :page-title="$metaInfo->metaTitle !='' ? $metaInfo->metaTitle : env('APP_NAME')" :page-description="$metaInfo->metaDescription !='' ? $metaInfo->metaDescription : ''">
    <x-hero :products="$products" :categories="$categories" :attrs="$attrs"/>
<!--
<section class="why-points top-content-container pt-4 pb-4">
    <div class="container">
        <div class="row">
            <div class="overflow-hidden col-md-4 position-relative mt-3">
                <div class="card mb-0">
                    <div class="d-block w-100 h-100 px-4 pt-4 pb-5">
                        <h2 class="text-black fw-700">Custom Design</h2>
                        <p class="text-black h6 font-weight-light" style="line-height: 1.5"> Anything you have in mind we can create! Do you have a ring, chain, or pendant idea in mind? Let us know and we can create a 3D model so it can be created. </p> <a href="https://districtties.com/product/custom-cad" class="btn btn-primary mt-4">Custom CAD Inquiry <i class="fa-solid fa-arrow-right"></i></a> </div>
                </div>
            </div>
            <div class="overflow-hidden col-md-4 position-relative mt-3">
                <div class="card mb-0 h-100">
                    <div class="d-block w-100 h-100 px-4 pt-4 pb-5">
                        <h2 class="text-black fw-700">Knowledge Base Blog</h2>
                        <p class="text-black h6 font-weight-light" style="line-height: 1.5"> Learn the behind the scenes process of how jewelry is made from start to finish. </p> <a class="btn btn-primary mb-3 mt-2" href="https://districtties.com/blog/category/knowledge-base">View Blog <i class="fa-solid fa-arrow-right"></i></a> </div>
                </div>
            </div>
            <div class="overflow-hidden col-md-4 position-relative mt-3">
                <div class="card mb-0 h-100">
                    <div class="d-block w-100 h-100 px-4 pt-4 pb-5">
                        <h2 class="text-black fw-700">Cost Analysis Blog</h2>
                        <p class="text-black h6 font-weight-light" style="line-height: 1.5"> See us breakdown what some of the most popular jewelry cost to make. </p> <a class="btn btn-primary mb-3 mt-2" href="https://districtties.com/blog/category/cost-analysis">View Blog <i class="fa-solid fa-arrow-right"></i></a> </div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-app-layout>
