<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Video\V1\Room\ParticipantList;
use Twilio\Rest\Video\V1\Room\RoomRecordingList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property \Twilio\Rest\Video\V1\Room\RoomRecordingList $recordings
 * @property \Twilio\Rest\Video\V1\Room\ParticipantList $participants
 * @method \Twilio\Rest\Video\V1\Room\RoomRecordingContext recordings(string $sid)
 * @method \Twilio\Rest\Video\V1\Room\ParticipantContext participants(string $sid)
 */
class RoomContext extends InstanceContext {
    protected $_recordings = null;
    protected $_participants = null;

    /**
     * Initialize the RoomContext
     *
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $sid The SID that identifies the resource to fetch
     * @return \Twilio\Rest\Video\V1\RoomContext
     */
    public function __construct(Version $version, $sid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array('sid' => $sid, );

        $this->uri = '/Rooms/' . \rawurlencode($sid) . '';
    }

    /**
     * Fetch a RoomInstance
     *
     * @return RoomInstance Fetched RoomInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch() {
        $params = Values::of(array());

        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );

        return new RoomInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Update the RoomInstance
     *
     * @param string $status The new status of the resource
     * @return RoomInstance Updated RoomInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update($status) {
        $data = Values::of(array('Status' => $status, ));

        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );

        return new RoomInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Access the recordings
     *
     * @return \Twilio\Rest\Video\V1\Room\RoomRecordingList
     */
    protected function getRecordings() {
        if (!$this->_recordings) {
            $this->_recordings = new RoomRecordingList($this->version, $this->solution['sid']);
        }

        return $this->_recordings;
    }

    /**
     * Access the participants
     *
     * @return \Twilio\Rest\Video\V1\Room\ParticipantList
     */
    protected function getParticipants() {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['sid']);
        }

        return $this->_participants;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return \Twilio\ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get($name) {
        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown subresource ' . $name);
    }

    /**
     * Magic caller to get resource contexts
     *
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return \Twilio\InstanceContext The requested resource context
     * @throws TwilioException For unknown resource
     */
    public function __call($name, $arguments) {
        $property = $this->$name;
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array(array($property, 'getContext'), $arguments);
        }

        throw new TwilioException('Resource does not have a context');
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.RoomContext ' . \implode(' ', $context) . ']';
    }
}