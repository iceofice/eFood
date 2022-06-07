<div id="reserve-section" data-section="reservation">
    <div class="container">
        <div class="row text-center fh5co-heading row-padded">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="heading to-animate">Reserve a Table</h2>
                <p class="sub-heading to-animate">
                    Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                    there live the
                    blind texts.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 to-animate-2">
                <h3>Reservation Form</h3>
                <form action="{{ route('front.reserve') }}" method="POST">
                    @csrf
                    <x-adminlte-input type="number" class="form-control" id="pax" name="pax"
                        placeholder="Number Of People" />
                    @php
                        $config = [
                            'format' => 'L',
                        ];
                    @endphp
                    <x-adminlte-input-date name="date" placeholder="Reservation date" enable-old-support
                        :config="$config" />
                    <span id="message">Fill both date and table to see available time.</span>
                    {{-- TODO: Fix Sizing on different windows size --}}
                    <x-adminlte-select2 class="form-control" name="time" placeholder="Time" enable-old-support>
                    </x-adminlte-select2>
                    <input type="hidden" name="table_id" id="table_id" />
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                    <input class="btn btn-primary btn-outline" value="Reserve" type="submit" />
                </form>

            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        let time;
        let pax;
        let timedata;
        $('#time').prop("disabled", true);

        $("#date").on("change.datetimepicker", ({
            date,
            oldDate
        }) => {
            time = date.format("YYYY-MM-DD");
            checkTime();
        });

        $('#pax').on("input", function() {
            pax = $(this).val();
            checkTime();
        });

        $('#time').on('change.select2', function(e) {
            var x = $('#time').select2('data')[0].text
            var obj = timedata.data[x];
            var table_id = obj[Object.keys(obj)[0]]
            $('#table_id').val(table_id);
        });

        function checkTime() {
            if (time && pax) {
                $.get('{{ route('front.checkTable') }}', {
                        'time': time,
                        'pax': pax
                    },
                    function(data) {
                        timedata = data
                        $('#time').find('option').remove();
                        if (data.error) {
                            $('#time').prop("disabled", true);
                            $('#message').html(data.message);
                        } else {
                            $('#time').prop("disabled", false);
                            $('#message').html('Available time');
                            $.each(data.data, function(i, item) {
                                $('#time').append($('<option>', {
                                    value: i,
                                    text: i
                                }));
                            });
                        }
                        $('#time').val(Object.keys(timedata.data)[0]).trigger('change.select2');
                    });
            }
        }
    </script>
@endsection
