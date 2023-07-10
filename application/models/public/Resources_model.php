<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->tables = [
        	'posts' => 'posts',
        	'posts_categories' => 'posts_categories',
        	'categories' => 'categories' 
        ]; 
    }

    public function get_top_recent_articles()
    {
    	$this->db->select($this->tables['posts'].'.*');
    	$this->db->where($this->tables['posts'].'.status', 1);
    	$this->db->where($this->tables['posts'].'.published_at <= ', date('Y-m-d'));
    	$this->db->order_by($this->tables['posts'].'.published_at','DESC');
    	$this->db->limit(3);
    	$query = $this->db->get($this->tables['posts']);

    	if ($query->num_rows() > 0) {
    		$articles  = $query->result();
    		foreach ($articles as $key => $article) {
    			$article->categories = $this->get_article_category($article->id);
    		}
            return $articles;
        }
        return false;
    }

    public function get_article_category($id)
    {
    	$this->db->select($this->tables['posts_categories'].'.*,'.$this->tables['categories'].'.name');
    	$this->db->join($this->tables['categories'], $this->tables['categories'].'.id = '.$this->tables['posts_categories'].'.category_id');
    	$this->db->where($this->tables['posts_categories'].'.post_id', $id);
    	$query = $this->db->get($this->tables['posts_categories']);

    	if ($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return [];
    	}
    }

    public function get_other_articles($articles)
    {
    	$ids = [];
    	if (!empty($articles)) {
    		foreach ($articles as $key => $article) {
    			$ids[] = $article->id;
    		}
    	}

    	$this->db->select($this->tables['posts'].'.*');
    	if (!empty($ids)) {
           $this->db->where_not_in($this->tables['posts'].'.id', $ids);
        }
    	$this->db->where($this->tables['posts'].'.status', 1);
    	$this->db->where($this->tables['posts'].'.published_at <= ', date('Y-m-d'));
    	$this->db->order_by($this->tables['posts'].'.published_at','DESC');
    	$query = $this->db->get($this->tables['posts']);

    	if ($query->num_rows() > 0) {
    		$articles  = $query->result();
    		foreach ($articles as $key => $article) {
    			$article->categories = $this->get_article_category($article->id);
    		}
            return $articles;
        }
        return false;
    }

    public function get_top_favourite_articles()
    {
    	$this->db->select($this->tables['posts'].'.*');
    	$this->db->where($this->tables['posts'].'.status', 1);
    	$this->db->where($this->tables['posts'].'.published_at <= ', date('Y-m-d'));
    	$this->db->order_by($this->tables['posts'].'.published_at','DESC');
    	$this->db->limit(3);
    	$query = $this->db->get($this->tables['posts']);

    	if ($query->num_rows() > 0) {
    		$articles  = $query->result();
    		foreach ($articles as $key => $article) {
    			$article->categories = $this->get_article_category($article->id);
    		}
            return $articles;
        }
        return false;
    }
    
    public function get_other_favourite_articles($articles)
    {
    	$ids = [];
    	if (!empty($articles)) {
    		foreach ($articles as $key => $article) {
    			$ids[] = $article->id;
    		}
    	}

    	$this->db->select($this->tables['posts'].'.*');
        if (!empty($ids)) {
    	   $this->db->where_not_in($this->tables['posts'].'.id', $ids);
        }
    	$this->db->where($this->tables['posts'].'.status', 1);
    	$this->db->where($this->tables['posts'].'.published_at <= ', date('Y-m-d'));
    	$this->db->order_by($this->tables['posts'].'.published_at','DESC');
    	$query = $this->db->get($this->tables['posts']);

    	if ($query->num_rows() > 0) {
    		$articles  = $query->result();
    		foreach ($articles as $key => $article) {
    			$article->categories = $this->get_article_category($article->id);
    		}
            return $articles;
        }
        return false;
    }

    public function get_article($slug)
    {
        $this->db->select($this->tables['posts'].'.*');
        $this->db->where($this->tables['posts'].'.status', 1);
        $this->db->where($this->tables['posts'].'.slug', $slug);
        $query = $this->db->get($this->tables['posts']);

        if ($query->num_rows() > 0) {
            $article  = $query->row();
            $article->categories = $this->get_article_category($article->id);
            return $article;
        } else {
            return false;
        }
    }
}