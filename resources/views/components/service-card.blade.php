@props(['service'])
<div class="game-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
    <div class="inner-box">
        <div class="image-box">
            <figure class="image"><a href="#"><img src="{{ $service->getFirstMediaUrl('service-image') }}"
                        alt="" title=""></a>
            </figure>
            <div class="link-box"><a href="#" class="link-btn"> <span class="btn-title">Detail Service</span></a>
            </div>
        </div>
        <div class="lower-content">
            <h3><a href="#">{{ $service->nama }}</a></h3>
            <div class="text">{{ $service->deskripsi }}
            </div>
            <div class="post-info">
                <ul class="clearfix">
                    <li><span class="icon flaticon-console"></span>{{ $service->slot }} Slot</li>
                </ul>
            </div>
        </div>
    </div>
</div>
