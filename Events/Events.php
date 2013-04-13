<?php
/**
 * User: etorras
 * Date: 7/04/13
 */

namespace PS\Bundle\PSPointsBundle\Events;


final class Events {
    const PRE_PERSIST_POINTS = 'psps.points.event.pre_persist_points';
    const POST_PERSIST_POINTS = 'psps.points.event.post_persist_points';
    const PRE_PERSIST_USERPOINTS = 'psps.points.event.pre_persist_userpoints';
    const POST_PERSIST_USERPOINTS = 'psps.points.event.post_persist_userpoints';

}
