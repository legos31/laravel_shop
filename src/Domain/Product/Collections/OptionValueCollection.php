<?php


namespace Domain\Product\Collections;


use Illuminate\Database\Eloquent\Collection;

class OptionValueCollection extends Collection
{
    public function keyValues()
    {
        return $this->mapToGroups(Function ($item) {
            return [$item->option->title => $item];
        });
    }

}
