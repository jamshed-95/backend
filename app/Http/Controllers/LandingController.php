<?php


namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Content;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{

    public function getBlogs()
    {
        $getResent = Blog::where('Publish', 'yes')->orderBy('id', 'desc')->limit(4)->get();
        $bId = "";
        foreach ($getResent as $blog) {
            if ($bId == "") {
                $bId = $blog->id;
            } else {
                $bId .= "," . $blog->id;
            }
        }
        $getAll = Blog::where('Publish', 'yes')->whereRaw('id not in (' . $bId . ')')->orderBy('id', 'desc')->get();
        $blogs["recent"] = $getResent;
        $blogs["all"] = $getAll;
        return json_encode($blogs);
    }

    public function blogContent($id)
    {
        $blog = Blog::where('unique_id', $id)->first();
        if ($blog) {
            $test = $blog->content;
            $blogIdIN = "";
            foreach (explode(',', $test) as $blogId) {
                if ($blogIdIN == '') {
                    $blogIdIN = '\'' . trim($blogId) . '\'';
                } else {
                    $blogIdIN .= ',\'' . trim($blogId) . '\'';
                }
            }
            $content = Content::whereRaw('content.blog_unique_id in (' . $blogIdIN . ')')->with("feadback")->get();
            foreach ($content as &$state) {
                $state->Text = str_replace("[b]", "<b>", $state->Text);
                $state->Text = str_replace("[/b]", "</b>", $state->Text);
                $state->Text = str_replace("[i]", "<i>", $state->Text);
                $state->Text = str_replace("[/i]", "</i>", $state->Text);
                $state->Text = str_replace("•", "<br/>•", $state->Text);
                $state->Text = str_replace("[url=", "<a href=\"", $state->Text);
                $state->Text = str_replace("][color=", "\" style=\"color:", $state->Text);
                $state->Text = str_replace("FF]", "FF\">", $state->Text);
                $state->Text = str_replace("[/color][/url]", "</a>", $state->Text);
                $state->Text = str_replace("[color=#808080][size=5]", "<span style='color:#808080;size:5px '>", $state->Text);
                $state->Text = str_replace("[color=#808080][size=4]", "<span style='color:#808080;size:4px '>", $state->Text);
                $state->Text = str_replace("[/size][/color]", "</span>", $state->Text);

                $state->Sub_title = str_replace("[color=#808080][size=5]", "<span style='color:#808080;size:5px '>", $state->Sub_title);
                $state->Sub_title = str_replace("[color=#808080][size=4]", "<span style='color:#808080;size:4px '>", $state->Sub_title);
                $state->Sub_title = str_replace("[/size][/color]", "</span>", $state->Sub_title);
                $state->Sub_title = str_replace("null", "", $state->Sub_title);

                $state->IMG = str_replace("null", "", $state->IMG);

            }
            unset($state);
            $getResent = Blog::where('Publish', 'yes')->orderBy('id', 'desc')->get()->toArray();
            $keys = array_rand($getResent, 3);
            $resRes[] = $getResent[$keys[0]];
            $resRes[] = $getResent[$keys[1]];
            $resRes[] = $getResent[$keys[2]];
            $data = [];
            $data['blog'] = [$blog];
            $data['content'] = $content;
            $data["recent"] = $resRes;
            return json_encode($data);
        }
        return null;
    }

}
