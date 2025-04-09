<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\PartnersLogo\PartnerLogoCollection;
use App\Http\Resources\Review\GoogleReviewCollection;
use App\Http\Resources\SectionSettings\SectionSettingImages;
use App\Http\Resources\Service\OurServiceCollection;
use App\Http\Resources\Team\TeamCollection;
use App\Models\Blog\Blog;
use App\Models\Review\GoogleReview;
use App\Models\Service\OurService;
use App\Models\Settings\PartnershipLogo;
use App\Models\Settings\SectionSettingImage;
use App\Models\Team\Team;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function partnerLogo()
    {
        $logos = PartnershipLogo::where('status', 1)->get();
        return PartnerLogoCollection::collection($logos);
    }

    public function sectionImages()
    {
        $sectionImages = SectionSettingImage::where('status', 1)->get();
        return SectionSettingImages::collection($sectionImages);
    }

    public function getTeamMembers()
    {
        $teamMembers = Team::where('status', 1)->orderBy('index')->get();
        return TeamCollection::collection($teamMembers);
    }

    public function getGoogleReview()
    {
        $googleReview = GoogleReview::where('status',1)->get();
        return GoogleReviewCollection::collection($googleReview);
    }

    public function getOurService()
    {
        $service = OurService::where('status', 1)->get();
        return OurServiceCollection::collection($service);
    }

    public function getBlogPost()
    {
        $blogPosts = Blog::where('status', 1)->with('tags')->orderBy('created_at', 'desc')->paginate(5);
        return BlogCollection::collection($blogPosts);
    }


}
