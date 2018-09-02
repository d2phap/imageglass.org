<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Request;
use Response;

class HomeController extends Controller
{
    public function index() {

		// get the latest relese info
		$release_item = $this::getRequest("/api/release/latest");


		// get the latest news items
		$news_items = $this::getRequest("/api/news", array("limit" => "5"));

		// get the review list from json
		$review_items = $this::getJsonData("review_items.json");


		// page data
		$this->data["release_item"] = $release_item;
		$this->data["news_items"] = $news_items;
		$this->data["review_items"] = $review_items;


		// meta tags
		$this->data["_page"] = "home";
		$this->data["_thumbnail"] = url("upload/photo/release", $release_item["image"]);

        return view("pages.home.home")->with($this->data);
    }


    public function sitemap_xml()
	{
		$this->data["news_items"] = $this::getRequest("/api/news");
		$this->data["release_items"] = $this::getRequest("/api/releases");
		$this->data["theme_items"] = $this::getRequest("/api/themes");

		$content = view("pages.sitemap-xml")->with($this->data);
		return Response::make($content, "200")->header("Content-Type", "text/xml");
    }
    
}