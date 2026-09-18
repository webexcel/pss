<?php
class Contents
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'sn' => 'ID',
            'title' => 'Title'
        ];

        return $ordering;
    }
}
?>
