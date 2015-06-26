<?php

namespace Seclude2\Event;

abstract class Event {

    private $cancel = false;

    public final function setCancelled ($cancel) {
        $this->cancel = $cancel;
    }
    
    public function isCancelled {
        return $this->cancel;
    }

}
