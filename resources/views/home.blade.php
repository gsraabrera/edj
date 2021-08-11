@extends('layouts.app')
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
.custom-shape-divider-bottom-1607321078 {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;  
    line-height: 0;
    transform: rotate(180deg);
}

.custom-shape-divider-bottom-1607321078 svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 160px;
    transform: rotateY(180deg);
}

.custom-shape-divider-bottom-1607321078 .shape-fill {
    fill: #FFFFFF;
}

.front-sec
{
  position:relative;
  background: #dadada;
  background: linear-gradient(to bottom,#e8e8e8ba, #989898cc), url(https://www.toptal.com/designers/subtlepatterns/patterns/crosses.png) top center;
}

.btn.btn-outline-maroon {
    border: solid #8d1436;
    color: #8d1436;
}
.btn.btn-outline-maroon:hover {
    color: #730e2b;
    text-decoration: none;
}

.white-bg{
    background: white;
}
/* carousel */
.blog .carousel-indicators {
	left: 0;
	top: auto;
    bottom: -40px;

}

/* The colour of the indicators */
.blog .carousel-indicators li {
    background: #a3a3a3;
    border-radius: 50%;
    width: 8px;
    height: 8px;
}

.blog .carousel-indicators .active {
background: #707070;
}
</style>
@endsection
@section('content')
<div class="container front-sec">
          <!-- Content -->
            <div class="custom-shape-divider-bottom-1607321078">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
                    </svg>
            </div>
            <!--Grid row-->
            <div class="row wow fadeIn py-5 ">
 
            <!--Grid column-->
            <div class="col-md-8 mb-4 mt-5 text-center text-md-center">

            <h3 class="display-4 " style="color:#00563F; font-size:40px; font-weight:400">
                Vol {{ $data->first()->volume }} No {{ $data->first()->issue_no }} ({{ $data->first()->year }}): Ecosystems and Development Journal
            </h3>
            <hr >
            <p>
                <strong>Date Published: {{ $data->first()->date_published }} </strong>
            </p>

        
            <a 
                target="_blank" 
                href="{{ route('issue.issue', $data->first()->slug) }}" 
                class="btn btn-outline-maroon waves-effect btn-lg"
            >
                Read More
                <i class="fa fa-book ml-2"></i>
            </a>

            </div>
            <!--Grid column-->
            <div class="col-md-4 mb-4 mt-5 text-center text-md-left ">          
            <!--Grid column-->
                    <img src="{{url('/cover_image/'.$data->first()->cover_image)}}" id="cover_image_id" style="width: 70%" class="shadow-sm">
            <!--/.Card-->
            </div>
            </div>
            <!--Grid column-->
            </div>
<!--Grid row-->


<section id="features" class="section feature-box text-center" style="margin-top: -10px;" >
      <div class="container wt-background color-block white-bg  pb-5">
          <!-- Section heading -->
          <h2 
            class="title green-text font-weight-bold my-2 wow fadeIn" 
            data-wow-delay="0.2s" 
            style="visibility: visible; animation-name: fadeIn; animation-delay: 0.2s;   
            font-size: 34px;"
          >
                    <strong class="green-text">Ecosystems and Development Journal</strong><br/> <small>(ISSN: 2012-3612)</small>
                </h2>
                <hr class="my-3">
                <!-- Section sescription -->
                <p class="black-text w-responsive mx-auto mb-3 wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-name: fadeIn; animation-delay: 0.2s;">
                   An international refereed journal published semi-annually designed to fill the science-policy interface void in the Philippines and other tropical countries to help legislators, policy-makers, researchers, and natural ecosystems managers become better equipped, more relevant, and more effective.</p>

                <a  href="{{ route('page','about') }}" class="btn btn-outline-maroon btn-lg">
                  Read More
                </a>
                <a  href="login" class="btn btn-outline-maroon btn-lg">
                  Submit an article
                </a>
      </div>
    </section>




    <section class="section feature-box wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-name: fadeIn; animation-delay: 0.2s; ">
        <div class="container py-5 px-5" style="background:#fdfdfd">
            <h4>
              <strong>E&amp;D Journal Guide to Authors</strong>
            </h4> 
            <hr class="my-4">   
            <p><strong>E&amp;D Journal</strong> welcomes articles from its readers, friends of the environment, and development advocates. Preferred contributions are well thought?out research articles, policy development articles, and research notes that deal on current issues, on?going debates, and emerging concerns on sustainable<br />
            development in tropical forest ecosystems and natural resource environment in the Philippines and other tropical countries. We are particularly interested in the following areas: forest biodiversity; watersheds; protected areas; geology and soils; ecosystem services, functions, and benefits; wildlife<br />
            conservation; habitat restoration; forest rehabilitation including agroforestry; plantation forestry; sustainable harvesting of forest products; biotechnology; geomatics; geohazards; climate change; ecotourism; human?nature interactions; forest economics, institutions, and governance.</p>

            <p>&nbsp;</p>

            <p><strong>TYPES OF ARTICLES</strong><br />
            Articles must be original, unpublished, not more than 25 pages long (including the abstract, tables,figures, maps, and appendices), and not submitted to other publications for consideration. We accept the<br />
            following types of articles:<br />
            Research articles should deal with recent findings and data that offer original, innovative, and scientific results relevant to sustainable development; and present new knowledge on systems and how it relates to the society, the economy, and the environment, and its potential application.<br />
            Policy development articles must present insights into well?researched and validated development and policy experiences exploring technological aspects in the tropical forest ecosystems and natural resources environment context; findings of practice?oriented research aimed at coping with development challenges and are embedded in national and international policy debates; must cite key documents; and explore the development of ecosystems.<br />
            Research notes refer to submitted articles with important findings and require immediate publication but cannot be considered as a journal article.</p>

            <p><br />
            <strong>RECOMMENDED FORMAT</strong><br />
            1. Manuscripts should be processed in Microsoft Word 1993?2007 (A4 paper, double?spaced, 12?points Times New Roman) and in American English language. Articles should be submitted with the following sections:<br />
            Title &ndash; should be less than 20 words and must contain the subject and the significance or purpose of the study (to be followed by list of author/s and affiliation/s, and corresponding author&rsquo;s e?mail address) on one page.<br />
            Abstract ? not more than 250 words and a list of at most five keywords.<br />
            Introduction<br />
            Methodology &ndash; should specify the techniques used and the details of the study area, as well as the limitations of the study<br />
            Results and Discussion<br />
            Conclusion<br />
            Literature Cited<br />
            List of Figures and Tables<br />
            Acknowledgments &ndash; paragraph composed of at most three sentences<br />
            2. Manuscripts (including tables, figures, photos, maps, and appendices) should be submitted by e?mail or online submission.</p>

            <p>3. Manuscripts with multiple authors are requested to have the co?authorship agreement form signed and submitted.</p>

            <p>&nbsp;</p>

            <p><strong>OTHER DETAILS</strong><br />
            1. Use the metric system for data that require units of measure.<br />
            2. Use italic type for scientific names, local names and terms, and non?English terms.<br />
            3. Submit all figures as separate files; do not integrate them within the text.<br />
            4. Use the table functions of your word processing program, not spreadsheets, to make tables.<br />
            5. Use the equation editor of your word processing program or Math Type for equations.<br />
            6. Number the pages using the automatic numbering function.<br />
            7. Use continuous line numbering.<br />
            8. Place figure legends or tables at the end of the manuscript.<br />
            9. Use left paragraph alignment only (do not justify lines; allow the automatic line wrap to function).<br />
            10. Start all heads flush left.<br />
            11. Use 2 line spacing all throughout (do not automatically insert extra space before or after paragraphs).</p>

            <p>&nbsp;</p>

            <p><strong>CITING REFERENCES</strong><br />
            1. Authors cited in the text, figures, and table captions should be listed in the Literature Cited section.<br />
            2. Authors cited as &ldquo;et al.&rdquo; in the text should all be enumerated in the References Cited.<br />
            3. For citing bibliographic references, refer to the format guidelines here.</p>

            <p>&nbsp;</p>

            <p><strong>REVIEW PROCESS</strong><br />
            Manuscripts undergo a double?blind peer review. Effort should be made by the author to prevent his or<br />
            her identity from being known during the review process.</p>
                       
        </div>
      </section>

      <section class="section feature-box wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-name: fadeIn; animation-delay: 0.2s;" >
        <div class="container py-5 white-bg"  >
          <h1 class="text-center green-text mb-5" style="font-weight:bold;">Issues</h1>
            <!-- Slider main container -->
            <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @if(!empty($data) && $data->count())

                    @foreach($data as $key => $value)
                        <div class="swiper-slide">
                            <a href="{{ route('issue.issue',$value->slug) }}">
                            <img src="{{url('/cover_image/'.$value->cover_image)}}" style="max-width:100%;">
                            <p style="text-align: center; font-weight: bold;">Vol {{ $value->volume }} No {{ $value->issue_no }} {{ $value->year }}: Ecosystems and Development Journal
                            </p>
                            </a>
                        </div>
                        
                    @endforeach
                @endif
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
            </div>
        </div>

      </section>
</div>

            

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    
    $(document).ready(function(){
        // console.log('test')
        // $('.slicky').slick();
    });
    document.addEventListener( 'DOMContentLoaded', function () {
        
	new Splide( '#image-slider',{
        type   : 'loop',
        heightRatio: 1,
	    perPage: 3
    } ).mount();

    $('#blogCarousel').carousel({
				interval: 5000
		});
    
} );




const swiper = new Swiper('.swiper-container', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
  breakpoints: {
    '@0.75': {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    '@1.00': {
      slidesPerView: 3,
      spaceBetween: 100,
    },
    '@1.50': {
      slidesPerView: 4,
      spaceBetween: 100,
    },
  }
});
</script>
@endsection