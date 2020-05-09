## History package



## Installation

This package is installed via [Composer](http://getcomposer.org/). To install, simply add to your `composer.json` file:

```
$ composer require hakobbabakhanyan/history
```

And now you can publish your config.

```
$ php artisan vendor:publish --provider "HakobBabakhanyan\History\Providers\HistoryServiceProvider"
```

## Using example in model

```php
<?php

namespace App;

use HakobBabakhanyan\History\History;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use History;

    protected  $history_columns = ['name'];

}
```
## Using example in contoller 

```php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /*** Returns histories
     * @param Request $request
     * @return array
     */
    public function history(Request $request) {
        $company = Post::query()->where('id',$request->get('id'))
                        ->with('histories')->firts();
        
        return $company->histories;
    }
    /*** Returns column value
     * @param Request $request
     * @return array
     */
    public function getHistoryColumn(Request $request) {
        $company = Post::query()->where('id',$request->get('id'))->firts();
        
        // request date "Y-m-d H:i:s"
        $column_value = $company->get_history_value($request->get('column'), $request->get('date'));
        
        return $column_value;
    }

}



```
