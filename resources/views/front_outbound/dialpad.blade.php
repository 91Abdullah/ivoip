<div class="dial-pad-wrap">
    <div class="left-pan">
        {{--<div class="contacts">--}}
            {{--<div class="title">Contacts</div>--}}
            {{--@foreach($contacts as $contact)--}}
                {{--<div class="people clearfix">--}}
                    {{--<div class="photo pull-left">--}}
                        {{--<img src="{{ asset('storage/user-img.jpg') }}">--}}
                    {{--</div>--}}
                    {{--<div class="info pull-left">--}}
                        {{--<div class="name">{{ $contact->name }}</div>--}}
                        {{--<div class="phone"><span class="number">{{ $contact->number }}</span></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endforeach--}}
        {{--</div>--}}
        <div class="calling">
            <div class="title fadeIn animated infinite">Calling</div>
            <div class="photo bounceInDown animated"></div>
            <div class="name rubberBand animated">Unknown</div>
            <div class="timer">00:00:00</div>
            <div class="number"></div>
            <div class="action">
                <div class="lnk"><button id="muteBtn" class="btn fadeInLeftBig animated"><i class="fa fa-mic"></i></button></div>
                <div class="lnk"><button id="holdBtn" class="btn fadeInUpBig animated"><i class="fa fa-vol"></i></button></div>
                <div class="lnk"><button id="transferBtn" class="btn fadeInRightBig animated"><i class="fa fa-arrow-circle-right"></i></button></div>
                {{--<div class="lnk"><button class="btn fadeInRightBig animated"><i class="fa fa-video-camera"></i></button></div>--}}
            </div>
            <div class="call-end bounceInUp animated">
                <button class="btn"><i class="fa fa-phone"></i></button>
            </div>
        </div>
    </div>
    <div class="dial-pad">
        <div class="dial-screen" contenteditable="false"></div>
        <div class="dial-table">
            <div class="dial-table-row">
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="1">
                        <div class="dial-key">1</div>
                        <div class="dial-sub-key">&nbsp;</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="2">
                        <div class="dial-key">2</div>
                        <div class="dial-sub-key">abc</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="3">
                        <div class="dial-key">3</div>
                        <div class="dial-sub-key">def</div>
                    </div>
                </div>
            </div>
            <div class="dial-table-row">
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="4">
                        <div class="dial-key">4</div>
                        <div class="dial-sub-key">ghi</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="5">
                        <div class="dial-key">5</div>
                        <div class="dial-sub-key">jkl</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="6">
                        <div class="dial-key">6</div>
                        <div class="dial-sub-key">mno</div>
                    </div>
                </div>
            </div>
            <div class="dial-table-row">
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="7">
                        <div class="dial-key">7</div>
                        <div class="dial-sub-key">pqrs</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="8">
                        <div class="dial-key">8</div>
                        <div class="dial-sub-key">tuv</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="9">
                        <div class="dial-key">9</div>
                        <div class="dial-sub-key">wxyz</div>
                    </div>
                </div>
            </div>
            <div class="dial-table-row">
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="*">
                        <div class="dial-key">*</div>
                        <div class="dial-sub-key">&nbsp;</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="0">
                        <div class="dial-key">0</div>
                        <div class="dial-sub-key">+</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="#">
                        <div class="dial-key">#</div>
                        <div class="dial-sub-key">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="dial-table-row no-sub-key">
                <div class="dial-table-col">
                    <a id="addContact" data-toggle="modal" data-target="#m_modal_6" style="color: #000;" href="javascript:void(0);">
                        <div class="dial-key-wrap" data-key="add">
                            <div class="dial-key"><i class="fa fa-plus"></i></div>
                            <div class="dial-sub-key">Add</div>
                        </div>
                    </a>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="call">
                        <div class="dial-key"><i class="fa fa-phone"></i></div>
                        <div class="dial-sub-key">Call</div>
                    </div>
                </div>
                <div class="dial-table-col">
                    <div class="dial-key-wrap" data-key="back">
                        <div class="dial-key"><i class="fa fa-long-arrow-left"></i></div>
                        <div class="dial-sub-key">Back</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>