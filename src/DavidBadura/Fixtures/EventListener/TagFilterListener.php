<?php

namespace DavidBadura\Fixtures\EventListener;

use DavidBadura\Fixtures\Event\PreExecuteEvent;

/**
 *
 * @author David Badura <d.badura@gmx.de>
 */
class TagFilterListener
{

    /**
     *
     * @param PreExecuteEvent $event
     */
    public function onPreExecute(PreExecuteEvent $event)
    {
        $collection = $event->getCollection();
        $options = $event->getOptions();

        if (empty($options['tags'])) {
            return;
        }

        if (!is_array($options['tags'])) {
            $options['tags'] = array($options['tags']);
        }

        /* @var $fixture Fixture */
        foreach ($collection as $fixture) {

            $tags = $fixture->getProperties()->get('tags');
            if(!$tags || !is_array($tags)) {
                $collection->remove($fixture->getName());
                continue;
            }

            foreach ($tags as $tag) {
                if (in_array($tag, $options['tags'])) {
                    continue 2;
                }
            }
            $collection->remove($fixture->getName());
        }
    }

}
