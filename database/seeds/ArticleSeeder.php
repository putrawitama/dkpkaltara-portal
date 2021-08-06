<?php

use Illuminate\Database\Seeder;
use App\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $str = strtolower('Lorem ipsum dolor sit amet');
        for ($i=0; $i < 15; $i++) { 
            Article::insert([
                'title' => 'Lorem ipsum dolor sit amet',
                'slug' => preg_replace('/\s+/', '-', $str).rand(1,100000),
                'thumbnail' => '["uploads\/image_article_16282146330.png"]',
                'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at consequat justo, non lobortis enim. Pellentesque auctor venenatis ipsum, vitae placerat ante volutpat quis. Phasellus eu libero nisl. Pellentesque magna augue, sollicitudin eu augue eu, condimentum efficitur elit. Mauris condimentum aliquet mattis. Aenean scelerisque ac libero sed lobortis. Fusce at lacus quis augue aliquam semper. Fusce ut congue felis. Sed sollicitudin metus sit amet nulla ornare elementum. Suspendisse consectetur neque facilisis ipsum blandit gravida. Integer id gravida metus, nec efficitur est. Curabitur eu ultricies dui, at fermentum felis. Aliquam vehicula ipsum vel aliquet malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis dolor quis arcu consectetur eleifend. Sed faucibus ligula dui.</p><p><br></p><p>Vestibulum iaculis tempus lectus bibendum aliquam. Sed sem orci, venenatis in bibendum laoreet, faucibus nec dui. Pellentesque posuere fermentum urna quis sollicitudin. Mauris justo erat, dictum ac arcu ut, dapibus rutrum libero. Nulla efficitur, nulla vitae tincidunt condimentum, nisi lectus luctus sapien, sed rutrum sapien nisl rutrum risus. Aenean venenatis gravida mi, venenatis ullamcorper lacus. Ut sed purus ullamcorper magna condimentum vestibulum accumsan id mi. Ut facilisis mauris sed diam varius, sit amet dignissim lorem tempor.</p><p><br></p><p>Pellentesque blandit, lectus tristique pellentesque tincidunt, tellus augue vulputate ipsum, congue feugiat dui enim ut justo. Donec mollis luctus lacus, at maximus justo imperdiet eu. Suspendisse potenti. Nam ac dignissim mi. Vivamus consectetur ac massa in bibendum. Donec eu sodales purus. Pellentesque sagittis quam quis libero aliquam, gravida auctor risus vehicula. Pellentesque sed mi et velit sodales consectetur.</p><p><br></p><p>Ut pulvinar mauris id diam facilisis ornare. Mauris facilisis venenatis diam id tristique. Quisque vitae pharetra diam. Proin venenatis cursus enim vel vulputate. Curabitur dignissim metus non augue aliquam fermentum. Suspendisse a fermentum felis, quis aliquam sapien. Etiam augue orci, gravida vitae sapien ut, tempor scelerisque dui. Ut euismod dolor sed nisl tincidunt sagittis. Vivamus rutrum elit in turpis rhoncus vehicula. Pellentesque nibh lectus, ultrices ac ipsum vel, malesuada consectetur odio. Nunc a molestie augue. Sed sagittis metus diam, at lacinia libero tristique eu.</p>',
                'sub_menu_id' => $i+1,
                'user_id' => 1,
                'publish' => 1
            ]);
        }
    }
}
