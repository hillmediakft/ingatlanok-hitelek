<?php
namespace System\Site\Model;
use System\Core\SiteModel;

class Blog_model extends SiteModel {

    protected $table = 'blog';

    function __construct() {
        parent::__construct();
    }

    /**
     * 	Visszaadja a blog tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function getBlogPosts($id = null)
    {
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('blog.id', '=', $id);
        }
        $this->query->set_join('left', 'blog_category', 'blog.category_id', '=', 'blog_category.id');
        $this->query->set_orderby(array('blog.add_date'), 'DESC');
        $result = $this->query->select();
         if(count($result) == 1) {
             return $result[0];
         } else {
             return $result;
         }
    }

    /**
     * 	Visszaadja a blog tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function blog_pagination_query($limit = null, $offset = null)
    {
//$this->query->debug(false);
        $this->query->set_columns(
            "SQL_CALC_FOUND_ROWS
            blog.* ,
            blog_category.category_name_" . $this->lang
        );
        
        if (!is_null($limit)) {
            $this->query->set_limit($limit);
        }
        if (!is_null($offset)) {
            $this->query->set_offset($offset);
        }
        $this->query->set_join('left', 'blog_category', 'blog.category_id', '=', 'blog_category.id');
        $this->query->set_orderby(array('blog.add_date'), 'DESC');
        return $this->query->select();
    }

    /**
     * 	A jobs_filter_query() metódus után kell meghívni,
     *  és visszaadja a limittel lekérdezett de a szűrésnek megfelelő összes sor számát
     */
    public function blog_pagination_count_query()
    {
        return $this->query->found_rows();
    }

    /**
     * 	Kategória szerint adj avissza  ablog bejegyzéseket
     * 	
     *
     * 	@return array az adott kategóriájú blog bejegyzések tömbje  
     */
    public function getBlogPostsByCategory($category)
    {
        $this->query->set_where('category_id', '=', $category);
        $this->query->set_join('left', 'blog_category', 'blog.category_id', '=', 'blog_category.id');
        $this->query->set_orderby(array('blog.add_date'), 'DESC');
        return $this->query->select();
    }

    /**
     * 	Visszaadja a blog_category tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function get_blog_categories()
    {
        $this->query->set_table(array('blog_category'));
        $this->query->set_columns('*');
        return $this->query->select();
    }

    /**
     * 	Visszaadja a blog_category tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function blog_category_query($id = null)
    {
        $this->query->set_table(array('blog_category'));
        $this->query->set_columns('*');
        if (!is_null($id)) {
            $id = (int) $id;
            $this->query->set_where('id', '=', $id);
        }
        $result = $this->query->select();

        return $result[0];
    }

    /**
     * 	Visszaadja a blog_category tábla tartalmát
     * 	Ha kap egy id paramétert (integer), akkor csak egy sort ad vissza a táblából
     *
     * 	@param $id Integer 
     */
    public function blog_query_by_category_pagination($id, $limit = null, $offset = null)
    {
//      $this->query->debug(false);
        $this->query->set_columns(
            "SQL_CALC_FOUND_ROWS 
            blog.* ,
            blog_category.category_name_" . $this->lang
            );
        $this->query->set_where('blog.category_id', '=', $id);
        $this->query->set_join('left', 'blog_category', 'blog.category_id', '=', 'blog_category.id');

        if (!is_null($limit)) {
            $this->query->set_limit($limit);
        }
        if (!is_null($offset)) {
            $this->query->set_offset($offset);
        }
        $this->query->set_orderby(array('blog.add_date'), 'DESC');
        return $this->query->select();
    }

}
?>