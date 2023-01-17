<?php

namespace App\Service;

use App\Model\Category;

class CategoryService
{
    public function getListCategory1Level()
    {
        $categories = Category::
            whereNull('parent_id')
            ->get();

        return $this->toArrayList($categories, 1, 1);
    }

    public function getListCategory2Levels()
    {
        $categories = Category::with('childrens')
            ->whereNull('parent_id')
            ->get();

        return $this->toArrayList($categories, 1, 2);
    }

    public function getListCategory3Levels()
    {
        $categories = Category::with('childrens', 'childrens.childrens')
            ->whereNull('parent_id')
            ->get();

        return $this->toArrayList($categories, 1,3);
    }

    public function getCategories3LevelsOfParent($parentID)
    {
        $categories = Category::with('childrens', 'childrens.childrens')
            ->where('id', $parentID)
            ->get();

        return $this->toArrayList($categories, 1,3);
    }

    private function toArrayList($categories, $currentLevel, $maxLevel) {
        $categoryArrs = [];
        foreach ($categories as $category) {
            $categoryArr = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
            ];

            if ($currentLevel < $maxLevel) {
                $categoryArr['childrens'] = $this->toArrayList($category->childrens, $currentLevel + 1, $maxLevel);
            }

            $categoryArrs[] = $categoryArr;
        }

        return $categoryArrs;
    }
}
