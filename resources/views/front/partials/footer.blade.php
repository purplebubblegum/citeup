
@inject('f_activities', 'App\Modules\Electrons\Activities\ActivityService')
@inject('f_news', 'App\Modules\Electrons\News\NewsService')
@inject('f_faqs', 'App\Modules\Electrons\Faqs\FaqService')
@inject('f_config', 'App\Modules\Electrons\Config\Config')

<!-- Footer Div -->
<div id="front-footer" style="">
    <div class="container">
        <div class="row upper-yard">
            <div class="col-sm-4">
                <img src="{{ asset('storage/images/web/logo_lg.png') }}" class="footer-img">
                <p class="footer-subtitle">Celebrating The Golden Era of Technology</p>
                <p>
                    Cite UP adalah serangkaian acara berupa perlombaan dan seminar yang 
                    diselenggarakan setiap tahun oleh jurusan Ilmu Komputer, Universitas Pertamina.
                </p>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-4">
                        <h3>Acara</h3>
                        <ul class="list-unstyled">
                            @foreach($f_activities->getMultiple([]) as $activity)
                                <li><a href="{{ route('activities', kebab_case($activity->name)) }}">{{ $activity->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h3>Berita</h3>
                        <ul class="list-unstyled">
                            @foreach($f_news->getMultiple(['sort' => 'created_at:desc', 'take' => 5]) as $item)
                                <li><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></li>
                            @endforeach
                            @if ($f_news->getMultiple([])->count() === 0)
                                <li>Tidak Ada Berita.</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h3>FAQ</h3>
                        <ul class="list-unstyled">
                            @foreach($f_faqs->getMultiple(['sort' => 'created_at:desc', 'take' => 5]) as $faq)
                                <li><a href="{{ route('faqs') }}">{{ $faq->question }}</a></li>
                            @endforeach
                            @if ($f_faqs->getMultiple([])->count() === 0)
                                <li>Tidak Ada FAQ.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="lower-yard">
            <div>&copy; {{ date('Y') }} Ilmu Komputer, Fakultas Sains &amp; Komputer, Universitas Pertamina.</div>
            <p class="help-block"><small>{{ $f_config->get('version') }}. Developed and maintained by <a href="https://github.com/purplebubblegum" style="color:#991e9b">purplebubblegum</a>.</small></p>
        </div>
    </div>
</div>
