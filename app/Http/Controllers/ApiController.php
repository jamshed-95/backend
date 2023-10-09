<?php


namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Content;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class ApiController extends Controller
{

    public function addBlog(Request $request)
    {
        try {
            $check = Blog::where('unique_id', $request->unique_id)->first();
            $time_create = date("Y-m-d H:i:s", strtotime($request->time_create));
            if ($request->time_create == "null") {
                $time_create = Carbon::now()->format("Y-m-d H:i:s");
            }
            if ($check) {
                DB::table('blog')->where('unique_id', $request->unique_id)
                    ->update([
                        'Alt' => $request->Alt,
                        'content' => $request->content,
                        'Description' => $request->Description,
                        'Feedback' => $request->Feedback,
                        'IMG' => $request->IMG,
                        'Priority' => $request->Priority,
                        'Publish' => $request->Publish,
                        'Title' => $request->Title,
                        'Creation_Date' => $request->Creation_Date,
                        'Modified_Date' => $request->Modified_Date,
                        'Slug' => $request->Slug,
                        'Creator' => $request->Creator,
                        'time_create' => $time_create,
                    ]);
                return ["status" => "success", "msg" => 'Данные обновлены!'];

            } else {
                $blog = new Blog();
                $blog->unique_id = $request->unique_id;
                $blog->Alt = $request->Alt;
                $blog->content = $request->content;
                $blog->Description = $request->Description;
                $blog->Feedback = $request->Feedback;
                $blog->IMG = $request->IMG;
                $blog->Priority = $request->Priority;
                $blog->Publish = $request->Publish;
                $blog->Title = $request->Title;
                $blog->Creation_Date = $request->Creation_Date;
                $blog->Modified_Date = $request->Modified_Date;
                $blog->Slug = $request->Slug;
                $blog->Creator = $request->Creator;
                $blog->time_create = $time_create;
                $blog->save();
            }
        } catch (\Exception $ex) {
            return ["status" => "Error", "msg" => 'Что-то пошло не так  ' . $ex->getMessage()];
        }
        return ["status" => "success", "msg" => 'Успешно'];
    }

    public function addBlogContent(Request $request)
    {
        $check = Content::where('blog_unique_id', $request->unique_id)->first();
        try {
            if ($check) {
                DB::table('content')->where('blog_unique_id', $request->unique_id)
                    ->update([
                        'Feedback' => $request->Feedback,
                        'Feedback_yes_no' => $request->Feedback_yes_no,
                        'IMG' => $request->IMG,
                        'Sub_title' => $request->Sub_title,
                        'Text' => $request->Text,
                        'Creation_Date' => $request->Creation_Date,
                        'Modified_Date' => $request->Modified_Date,
                    ]);
                return ["status" => "success", "msg" => 'Данные обновлены!'];
            } else {
                $content = new Content();
                $content->blog_unique_id = $request->unique_id;
                $content->Feedback = $request->Feedback;
                $content->Feedback_yes_no = $request->Feedback_yes_no;
                $content->IMG = $request->IMG;
                $content->Sub_title = $request->Sub_title;
                $content->Text = $request->Text;
                $content->Creation_Date = $request->Creation_Date;
                $content->Modified_Date = $request->Modified_Date;
                $content->save();
                return ["status" => "success", "msg" => 'Успешно'];
            }
        } catch (Exception $ex) {
            return ["status" => "Error", "msg" => 'Что-то пошло не так' . $ex->getMessage()];
        }

    }

    public function addFeedBack(Request $request)
    {
        try {
            $check = Feedback::where('blog_unique_id', $request->unique_id)->first();
            $create = date("Y-m-d H:i:s", strtotime($request->Creation_Datet));
            $modified = date("Y-m-d H:i:s", strtotime($request->Modified_Date));
            if ($check) {
                DB::table('feedbacks')->where('blog_unique_id', $request->unique_id)
                    ->update([
                        'Avatar' => $request->Avatar,
                        'Name' => $request->Name,
                        'post_in_company' => $request->post_in_company,
                        'Text' => $request->Text,
                        'Creation_Date' => $create,
                        'Modified_Date' => $modified,
                        'Slug' => $request->Slug,
                        'Creator' => $request->Creator,
                    ]);
                return ["status" => "success", "msg" => 'Данные обновлены!'];
            } else {
                $feed = new Feedback();
                $feed->blog_unique_id = $request->unique_id;
                $feed->Avatar = $request->Avatar;
                $feed->Name = $request->Name;
                $feed->post_in_company = $request->post_in_company;
                $feed->Text = $request->Text;
                $feed->Creation_Date = $create;
                $feed->Modified_Date = $modified;
                $feed->Slug = $request->Slug;
                $feed->Creator = $request->Creator;
                $feed->save();
                return ["status" => "success", "msg" => 'Успешно'];
            }
        } catch (Exception $ex) {
            return ["status" => "Error", "msg" => 'Что-то пошло не так' . $ex->getMessage()];
        }
    }

}
