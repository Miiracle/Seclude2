<?php

namespace Seclude2\Event;

final class EventManager {
    
    private $listeners = array ();
    
    public function registerListener (EventListener $listener) {
        $this->listeners [] = $listener;
    }
    
}
